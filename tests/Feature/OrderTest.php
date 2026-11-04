<?php

use App\Models\DetailOrder;
use App\Models\Event;
use App\Models\Kategori;
use App\Models\Order;
use App\Models\Tiket;
use App\Models\TipePembayaran;
use App\Models\User;

beforeEach(function () {
    $this->buyer = User::factory()->create();
    $this->paymentMethod = TipePembayaran::create([
        'nama' => 'Transfer Manual',
        'deskripsi' => 'Tunggu instruksi admin.',
        'is_active' => true,
    ]);
    $category = Kategori::create(['nama' => 'Konser']);
    $this->event = Event::create([
        'user_id' => $this->buyer->id,
        'kategori_id' => $category->id,
        'judul' => 'Konser Mendatang',
        'deskripsi' => 'Acara musik',
        'lokasi' => 'Jakarta',
        'gambar' => 'konser.jpg',
        'tanggal_waktu' => now()->addDays(10),
    ]);
    $this->ticket = Tiket::create([
        'event_id' => $this->event->id,
        'tipe' => 'reguler',
        'harga' => 125000,
        'stok' => 5,
    ]);
});

test('orders require an authenticated user', function () {
    $this->get(route('orders.index'))
        ->assertRedirect(route('login'));

    $this->postJson(route('orders.store'), [
        'event_id' => $this->event->id,
        'payment_method_id' => $this->paymentMethod->id,
        'items' => [['tiket_id' => $this->ticket->id, 'jumlah' => 1]],
    ])->assertUnauthorized();
});

test('a user can place an order and stock is reserved', function () {
    $response = $this->actingAs($this->buyer)->postJson(route('orders.store'), [
        'event_id' => $this->event->id,
        'payment_method_id' => $this->paymentMethod->id,
        'items' => [['tiket_id' => $this->ticket->id, 'jumlah' => 2]],
    ]);

    $response->assertOk()
        ->assertJsonPath('ok', true);

    $order = Order::findOrFail($response->json('order_id'));
    expect($order->status)->toBe('pending')
        ->and((float) $order->total_harga)->toBe(250000.0)
        ->and($order->payment_method_name)->toBe('Transfer Manual')
        ->and($order->payment_instructions)->toBe('Tunggu instruksi admin.')
        ->and($order->detailOrders)->toHaveCount(1)
        ->and((int) $this->ticket->fresh()->stok)->toBe(3);

    $this->actingAs($this->buyer)
        ->get(route('orders.show', $order))
        ->assertOk()
        ->assertSee('Tunggu instruksi admin.');
});

test('a user cannot order a ticket belonging to another event', function () {
    $otherEvent = Event::create([
        'user_id' => $this->buyer->id,
        'kategori_id' => $this->event->kategori_id,
        'judul' => 'Event Lain',
        'deskripsi' => 'Acara lain',
        'lokasi' => 'Bandung',
        'gambar' => 'lain.jpg',
        'tanggal_waktu' => now()->addDays(15),
    ]);
    $otherTicket = Tiket::create([
        'event_id' => $otherEvent->id,
        'tipe' => 'premium',
        'harga' => 300000,
        'stok' => 2,
    ]);

    $this->actingAs($this->buyer)->postJson(route('orders.store'), [
        'event_id' => $this->event->id,
        'payment_method_id' => $this->paymentMethod->id,
        'items' => [['tiket_id' => $otherTicket->id, 'jumlah' => 1]],
    ])->assertUnprocessable();

    expect(Order::count())->toBe(0)
        ->and((int) $otherTicket->fresh()->stok)->toBe(2);
});

test('a user cannot use an inactive payment method', function () {
    $this->paymentMethod->update(['is_active' => false]);

    $this->actingAs($this->buyer)->postJson(route('orders.store'), [
        'event_id' => $this->event->id,
        'payment_method_id' => $this->paymentMethod->id,
        'items' => [['tiket_id' => $this->ticket->id, 'jumlah' => 1]],
    ])->assertUnprocessable()
        ->assertJsonValidationErrors('payment_method_id');

    expect(Order::count())->toBe(0)
        ->and((int) $this->ticket->fresh()->stok)->toBe(5);
});

test('a user can only view and cancel their own pending orders', function () {
    $order = Order::create([
        'user_id' => $this->buyer->id,
        'event_id' => $this->event->id,
        'order_date' => now(),
        'total_harga' => 250000,
    ]);
    DetailOrder::create([
        'order_id' => $order->id,
        'tiket_id' => $this->ticket->id,
        'jumlah' => 2,
        'subtotal_harga' => 250000,
    ]);
    $this->ticket->decrement('stok', 2);

    $otherUser = User::factory()->create();
    $this->actingAs($otherUser)
        ->get(route('orders.show', $order))
        ->assertForbidden();

    $this->actingAs($this->buyer)
        ->post(route('orders.cancel', $order))
        ->assertRedirect(route('orders.show', $order))
        ->assertSessionHas('success');

    expect($order->fresh()->status)->toBe('cancelled')
        ->and((int) $this->ticket->fresh()->stok)->toBe(5);
});

test('admin can confirm a pending payment and regular users cannot access admin pages', function () {
    $order = Order::create([
        'user_id' => $this->buyer->id,
        'event_id' => $this->event->id,
        'order_date' => now(),
        'total_harga' => 125000,
    ]);

    $this->actingAs($this->buyer)
        ->get(route('admin.dashboard'))
        ->assertForbidden();
    $this->assertAuthenticatedAs($this->buyer);

    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin)
        ->patch(route('admin.histories.status', $order), ['status' => 'paid'])
        ->assertRedirect(route('admin.histories.show', $order));

    expect($order->fresh()->status)->toBe('paid')
        ->and($order->fresh()->paid_at)->not->toBeNull();

    $this->get(route('admin.histories.show', $order))
        ->assertOk()
        ->assertSee('Metode pembayaran');
});

test('admin cannot delete categories or events that are used by existing records', function () {
    $order = Order::create([
        'user_id' => $this->buyer->id,
        'event_id' => $this->event->id,
        'order_date' => now(),
        'total_harga' => 0,
    ]);
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)
        ->delete(route('admin.events.destroy', $this->event))
        ->assertRedirect(route('admin.events.index'))
        ->assertSessionHasErrors('event');

    $this->delete(route('admin.categories.destroy', $this->event->kategori_id))
        ->assertRedirect(route('admin.categories.index'))
        ->assertSessionHasErrors('category');

    expect(Event::find($this->event->id))->not->toBeNull()
        ->and(Order::find($order->id))->not->toBeNull();
});

test('the event page and admin dashboard render with seeded payment and order data', function () {
    $this->get(route('events.show', $this->event))
        ->assertOk()
        ->assertSee('Metode pembayaran')
        ->assertSee('Transfer Manual');

    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin)
        ->get(route('admin.dashboard'))
        ->assertOk()
        ->assertSee('Kelola pembayaran');

    $this->get(route('admin.events.show', $this->event))
        ->assertOk()
        ->assertSee('Tambah Ticket');
});
