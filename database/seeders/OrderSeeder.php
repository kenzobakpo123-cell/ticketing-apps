<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Order;
use App\Models\TipePembayaran;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $buyer = User::where('email', 'user@gmail.com')->firstOrFail();
        $event = Event::with('tikets')->orderBy('tanggal_waktu')->firstOrFail();

        if (Order::where('user_id', $buyer->id)->where('event_id', $event->id)->exists()) {
            return;
        }

        $ticket = $event->tikets()->orderBy('id')->firstOrFail();
        $paymentMethod = TipePembayaran::where('is_active', true)->first();

        DB::transaction(function () use ($buyer, $event, $ticket, $paymentMethod) {
            $ticket = $event->tikets()->lockForUpdate()->findOrFail($ticket->id);
            if ($ticket->stok < 1) {
                throw new \RuntimeException('Tidak ada stok tiket untuk pesanan contoh.');
            }

            $subtotal = (float) $ticket->harga;
            $order = Order::create([
                'user_id' => $buyer->id,
                'event_id' => $event->id,
                'order_date' => now(),
                'total_harga' => $subtotal,
                'tipe_pembayaran_id' => $paymentMethod?->id,
                'payment_method_name' => $paymentMethod?->nama,
                'payment_instructions' => $paymentMethod?->deskripsi,
                'status' => 'paid',
                'paid_at' => now(),
            ]);

            $order->detailOrders()->create([
                'tiket_id' => $ticket->id,
                'jumlah' => 1,
                'subtotal_harga' => $subtotal,
            ]);
            $ticket->decrement('stok');
        });
    }
}
