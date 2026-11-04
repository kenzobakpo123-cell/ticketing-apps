<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Order;
use App\Models\Tiket;
use App\Models\TipePembayaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('event')
            ->latest('order_date')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        abort_unless($order->user_id === Auth::id(), 403);

        $order->load('detailOrders.tiket', 'event');

        return view('orders.show', compact('order'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'event_id' => ['required', 'integer', 'exists:events,id'],
            'payment_method_id' => ['required', 'integer', 'exists:tipe_pembayarans,id'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.tiket_id' => ['required', 'integer', 'distinct', 'exists:tikets,id'],
            'items.*.jumlah' => ['required', 'integer', 'min:1'],
        ]);

        $order = DB::transaction(function () use ($data) {
            $event = Event::query()->lockForUpdate()->findOrFail($data['event_id']);
            $paymentMethod = TipePembayaran::query()
                ->where('is_active', true)
                ->find($data['payment_method_id']);

            if (! $paymentMethod) {
                throw ValidationException::withMessages([
                    'payment_method_id' => 'Metode pembayaran ini sudah tidak tersedia. Muat ulang halaman dan pilih metode lain.',
                ]);
            }

            if ($event->tanggal_waktu->isPast()) {
                throw ValidationException::withMessages([
                    'event_id' => 'Event ini sudah berlangsung dan tidak menerima pemesanan.',
                ]);
            }

            $items = collect($data['items'])->keyBy('tiket_id');
            $tickets = Tiket::query()
                ->where('event_id', $event->id)
                ->whereIn('id', $items->keys())
                ->orderBy('id')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            if ($tickets->count() !== $items->count()) {
                throw ValidationException::withMessages([
                    'items' => 'Satu atau lebih tiket tidak tersedia untuk event ini.',
                ]);
            }

            $total = 0;
            foreach ($items as $ticketId => $item) {
                $ticket = $tickets->get($ticketId);
                if ($ticket->stok < $item['jumlah']) {
                    throw ValidationException::withMessages([
                        'items' => "Stok tiket {$ticket->tipe} tidak mencukupi.",
                    ]);
                }

                $total += round((float) $ticket->harga * $item['jumlah'], 2);
            }

            $order = Order::create([
                'user_id' => Auth::id(),
                'event_id' => $event->id,
                'order_date' => Carbon::now(),
                'total_harga' => $total,
                'tipe_pembayaran_id' => $paymentMethod->id,
                'payment_method_name' => $paymentMethod->nama,
                'payment_instructions' => $paymentMethod->deskripsi,
                'status' => 'pending',
            ]);

            foreach ($items as $ticketId => $item) {
                $ticket = $tickets->get($ticketId);
                $subtotal = round((float) $ticket->harga * $item['jumlah'], 2);

                $order->detailOrders()->create([
                    'tiket_id' => $ticket->id,
                    'jumlah' => $item['jumlah'],
                    'subtotal_harga' => $subtotal,
                ]);

                $ticket->decrement('stok', $item['jumlah']);
            }

            return $order;
        });

        return response()->json([
            'ok' => true,
            'order_id' => $order->id,
            'redirect' => route('orders.show', $order),
        ]);
    }

    public function cancel(Order $order)
    {
        abort_unless($order->user_id === Auth::id(), 403);

        $order->cancelAndRestock();

        return redirect()
            ->route('orders.show', $order)
            ->with('success', 'Pesanan dibatalkan dan stok tiket dikembalikan.');
    }
}
