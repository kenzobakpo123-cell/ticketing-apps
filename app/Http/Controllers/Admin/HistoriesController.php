<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class HistoriesController extends Controller
{
    public function index()
    {
        $histories = Order::with(['user', 'event'])
            ->latest('order_date')
            ->paginate(15);

        return view('admin.history.index', compact('histories'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'event', 'detailOrders.tiket']);

        return view('admin.history.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['paid', 'cancelled'])],
        ]);

        if ($validated['status'] === 'paid') {
            $order->markAsPaid();
        } else {
            $order->cancelAndRestock();
        }

        return redirect()
            ->route('admin.histories.show', $order)
            ->with('success', $validated['status'] === 'paid'
                ? 'Pembayaran berhasil dikonfirmasi.'
                : 'Pesanan dibatalkan dan stok tiket dikembalikan.');
    }
}
