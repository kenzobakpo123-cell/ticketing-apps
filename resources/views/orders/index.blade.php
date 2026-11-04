<x-layouts.app>
    <section class="max-w-6xl mx-auto py-12 px-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold">Riwayat Pembelian</h1>
        </div>

        <div class="space-y-4">
            @forelse($orders as $order)
            <article class="card lg:card-side bg-base-100 shadow-md overflow-hidden">
                <figure class="lg:w-48">
                    <img src="{{ $order->event?->gambar
        ? (filter_var($order->event->gambar, FILTER_VALIDATE_URL)
            ? $order->event->gambar
            : asset('images/events/' . $order->event->gambar))
        : asset('assets/images/placeholder.jpg')
    }}" alt="{{ $order->event?->judul ?? 'Event' }}" class="w-full h-full object-cover" />

                </figure>

                <div class="card-body flex justify-between ">
                    <div>
                        <div class="font-bold">Order #{{ $order->id }}</div>
                        <div class="text-sm text-gray-500 mt-1">{{ $order->order_date->translatedFormat('d F Y, H:i') }}
                        </div>
                        <div class="text-sm mt-2">{{ $order->event?->judul ?? 'Event' }}</div>
                        <div class="mt-3">
                            <span class="rounded-full px-3 py-1 text-xs font-semibold
                                {{ $order->status === 'paid' ? 'bg-emerald-100 text-emerald-700' : ($order->status === 'cancelled' ? 'bg-slate-100 text-slate-600' : 'bg-amber-100 text-amber-700') }}">
                                {{ ['pending' => 'Menunggu pembayaran', 'paid' => 'Lunas', 'cancelled' => 'Dibatalkan'][$order->status] ?? ucfirst($order->status) }}
                            </span>
                        </div>
                    </div>

                    <div class="text-right">
                        <div class="font-bold text-lg">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</div>
                        <a href="{{ route('orders.show', $order) }}" class="btn btn-primary mt-3 text-white">Lihat
                            Detail</a>
                    </div>
                </div>
            </article>
            @empty
            <div class="alert alert-info">Anda belum memiliki pesanan.</div>
            @endforelse
        </div>
        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    </section>
</x-layouts.app>