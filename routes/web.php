<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\HistoriesController;
use App\Http\Controllers\Admin\TiketController;
use App\Http\Controllers\Admin\TipePembayaranController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\EventController as UserEventController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Events
Route::get('/events/{event}', [UserEventController::class, 'show'])->name('events.show');

Route::middleware('auth')->group(function () {
    // Order
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');

    Route::get('/dashboard', function () {
        return auth()->user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('home');
    })->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Category Management
        Route::resource('categories', CategoryController::class)->only(['index', 'store', 'update', 'destroy']);

        // Event Management
        Route::resource('events', AdminEventController::class);

        // Ticket actions are managed from the event detail page.
        Route::post('/tickets', [TiketController::class, 'store'])->name('tickets.store');
        Route::put('/tickets/{ticket}', [TiketController::class, 'update'])->name('tickets.update');
        Route::delete('/tickets/{ticket}', [TiketController::class, 'destroy'])->name('tickets.destroy');

        // Tipe Pembayaran Management
        Route::resource('tipe-pembayaran', TipePembayaranController::class);

        // Histories
        Route::get('/histories', [HistoriesController::class, 'index'])->name('histories.index');
        Route::get('/histories/{order}', [HistoriesController::class, 'show'])->name('histories.show');
        Route::patch('/histories/{order}/status', [HistoriesController::class, 'updateStatus'])->name('histories.status');
    });
});

require __DIR__.'/auth.php';
