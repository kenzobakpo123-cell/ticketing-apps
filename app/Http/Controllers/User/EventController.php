<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\TipePembayaran;

class EventController extends Controller
{
    public function show(Event $event)
    {
        $event->load(['tikets', 'kategori', 'user']);
        $paymentMethods = TipePembayaran::where('is_active', true)
            ->orderBy('nama')
            ->get();

        return view('events.show', compact('event', 'paymentMethods'));
    }
}
