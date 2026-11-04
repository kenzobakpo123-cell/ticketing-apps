<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class Order extends Model
{
    use HasFactory;

    protected $casts = [
        'total_harga' => 'decimal:2',
        'order_date' => 'datetime',
        'paid_at' => 'datetime',
    ];

    protected $fillable = [
        'user_id',
        'event_id',
        'order_date',
        'total_harga',
        'tipe_pembayaran_id',
        'payment_method_name',
        'payment_instructions',
        'status',
        'paid_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tikets()
    {
        return $this->belongsToMany(Tiket::class, 'detail_orders')
            ->withPivot('jumlah', 'subtotal_harga');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function detailOrders()
    {
        return $this->hasMany(DetailOrder::class);
    }

    public function tipePembayaran()
    {
        return $this->belongsTo(TipePembayaran::class);
    }

    public function markAsPaid(): void
    {
        DB::transaction(function () {
            $order = self::query()->lockForUpdate()->findOrFail($this->id);

            if ($order->status !== 'pending') {
                throw ValidationException::withMessages([
                    'status' => 'Hanya pesanan yang menunggu pembayaran yang dapat ditandai lunas.',
                ]);
            }

            $order->update([
                'status' => 'paid',
                'paid_at' => now(),
            ]);
        });

        $this->refresh();
    }

    public function cancelAndRestock(): void
    {
        DB::transaction(function () {
            $order = self::query()->lockForUpdate()->findOrFail($this->id);

            if ($order->status !== 'pending') {
                throw ValidationException::withMessages([
                    'status' => 'Hanya pesanan yang menunggu pembayaran yang dapat dibatalkan.',
                ]);
            }

            $details = $order->detailOrders()->orderBy('tiket_id')->get();
            $tickets = Tiket::query()
                ->whereIn('id', $details->pluck('tiket_id'))
                ->orderBy('id')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            foreach ($details as $detail) {
                if ($ticket = $tickets->get($detail->tiket_id)) {
                    $ticket->increment('stok', $detail->jumlah);
                }
            }

            $order->update(['status' => 'cancelled']);
        });

        $this->refresh();
    }
}
