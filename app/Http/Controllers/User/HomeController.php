<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Kategori;
use App\Models\Tiket;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = Kategori::all();

        $eventsQuery = Event::with(['kategori', 'tikets'])
            ->withMin('tikets', 'harga')
            ->where('tanggal_waktu', '>=', now())
            ->orderBy('tanggal_waktu', 'asc');

        if ($request->filled('kategori')) {
            $eventsQuery->where('kategori_id', $request->kategori);
        }

        if ($request->filled('q')) {
            $search = trim($request->q);
            $eventsQuery->where(function ($query) use ($search) {
                $query->where('judul', 'like', "%{$search}%")
                    ->orWhere('lokasi', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        $events = $eventsQuery->get();
        $featuredEvent = $events->first();
        $stats = [
            'events' => Event::where('tanggal_waktu', '>=', now())->count(),
            'categories' => $categories->count(),
            'tickets' => Tiket::sum('stok'),
        ];

        return view('home', compact('events', 'categories', 'featuredEvent', 'stats'));
    }
}
