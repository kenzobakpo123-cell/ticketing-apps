<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Order;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index()
    {
        $totalEvents = Event::count();
        $totalCategories = \App\Models\Kategori::count();
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $paidOrders = Order::where('status', 'paid')->count();
        $paidRevenue = Order::where('status', 'paid')->sum('total_harga');

        return view('admin.dashboard', compact(
            'totalEvents',
            'totalCategories',
            'totalOrders',
            'pendingOrders',
            'paidOrders',
            'paidRevenue',
        ));
    }
}
