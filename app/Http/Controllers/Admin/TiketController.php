<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tiket;
use Illuminate\Http\Request;

class TiketController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => ['required', 'integer', 'exists:events,id'],
            'tipe' => ['required', 'in:reguler,premium'],
            'harga' => ['required', 'numeric', 'min:0'],
            'stok' => ['required', 'integer', 'min:0'],
        ]);

        Tiket::create($validated);

        return redirect()
            ->route('admin.events.show', $validated['event_id'])
            ->with('success', 'Tiket berhasil ditambahkan.');
    }

    public function update(Request $request, Tiket $ticket)
    {
        $validated = $request->validate([
            'tipe' => ['required', 'in:reguler,premium'],
            'harga' => ['required', 'numeric', 'min:0'],
            'stok' => ['required', 'integer', 'min:0'],
        ]);

        $ticket->update($validated);

        return redirect()
            ->route('admin.events.show', $ticket->event_id)
            ->with('success', 'Tiket berhasil diperbarui.');
    }

    public function destroy(Tiket $ticket)
    {
        if ($ticket->detailOrders()->exists()) {
            return redirect()
                ->route('admin.events.show', $ticket->event_id)
                ->withErrors(['ticket' => 'Tiket yang sudah pernah dipesan tidak dapat dihapus agar riwayat transaksi tetap utuh.']);
        }

        $eventId = $ticket->event_id;
        $ticket->delete();

        return redirect()
            ->route('admin.events.show', $eventId)
            ->with('success', 'Tiket berhasil dihapus.');
    }
}
