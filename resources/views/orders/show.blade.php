<x-layouts.app>
    <section class="max-w-4xl mx-auto py-12 px-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold">Detail Pemesanan</h1>
            <div class="text-sm text-gray-500">Order #{{ $order->id }} •
                {{ $order->order_date->translatedFormat('d F Y, H:i') }}
            </div>
        </div>

        @if(session('success'))
            <div class="mb-5 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-800">
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="mb-5 rounded-2xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm text-rose-800">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="card bg-base-100 shadow-md">
            <div class="lg:flex ">
                <div class="lg:w-1/3 p-4">
                    <img src="{{ $order->event?->gambar
        ? (filter_var($order->event->gambar, FILTER_VALIDATE_URL)
            ? $order->event->gambar
            : asset('images/events/' . $order->event->gambar))
        : asset('assets/images/placeholder.jpg')
    }}" alt="{{ $order->event?->judul ?? 'Event' }}" class="w-full object-cover mb-2" />

                    <h2 class="font-semibold text-lg">{{ $order->event?->judul ?? 'Event' }}</h2>
                    <p class="text-sm text-gray-500 mt-1">{{ $order->event?->lokasi ?? '' }}</p>
                </div>
                <div class="card-body lg:w-2/3">


                    <div class="space-y-3">
                        @foreach($order->detailOrders as $d)
                        <div class="flex justify-between items-center">
                            <div>
                                <div class="font-bold">{{ $d->tiket?->tipe ?? 'Tiket' }}</div>
                                <div class="text-sm text-gray-500">Qty: {{ $d->jumlah }}</div>
                            </div>
                            <div class="text-right">
                                <div class="font-bold">Rp {{ number_format($d->subtotal_harga, 0, ',', '.') }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="divider"></div>

                    <div class="flex justify-between items-center">
                        <span class="font-bold">Total</span>
                        <span class="font-bold text-lg">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>

                    </div>
                    <div class="mt-4 flex items-center justify-between rounded-xl bg-slate-50 p-4">
                        <span class="font-medium text-slate-600">Status pesanan</span>
                        <span class="rounded-full px-3 py-1 text-sm font-semibold
                            {{ $order->status === 'paid' ? 'bg-emerald-100 text-emerald-700' : ($order->status === 'cancelled' ? 'bg-slate-200 text-slate-600' : 'bg-amber-100 text-amber-700') }}">
                            {{ ['pending' => 'Menunggu pembayaran', 'paid' => 'Lunas', 'cancelled' => 'Dibatalkan'][$order->status] ?? ucfirst($order->status) }}
                        </span>
                    </div>
                    <div class="mt-4 rounded-xl border border-blue-100 bg-blue-50 p-4">
                        <div class="font-semibold text-blue-900">Metode pembayaran: {{ $order->payment_method_name ?? $order->tipePembayaran?->nama ?? 'Tidak tersedia' }}</div>
                        @if($order->payment_instructions)
                            <p class="mt-2 whitespace-pre-line text-sm leading-6 text-blue-800">{{ $order->payment_instructions }}</p>
                        @endif
                    </div>
                    @if($order->status === 'pending')
                        <p class="mt-3 text-sm text-slate-500">Setelah membayar, tunggu admin memverifikasi pembayaran. Jika berubah pikiran, pesanan dapat dibatalkan dan stok tiket akan dikembalikan.</p>
                        <form method="POST" action="{{ route('orders.cancel', $order) }}" class="mt-4" onsubmit="return confirm('Batalkan pesanan ini? Stok tiket akan dikembalikan.')">
                            @csrf
                            <button type="submit" class="btn btn-outline btn-error">Batalkan pesanan</button>
                        </form>
                    @elseif($order->paid_at)
                        <p class="mt-3 text-sm text-slate-500">Pembayaran dikonfirmasi pada {{ $order->paid_at->translatedFormat('d F Y, H:i') }}.</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="mt-6">
            <a href="{{ route('orders.index') }}" class="btn btn-primary text-white">Kembali ke Riwayat Pembelian</a>
        </div>
    </section>
</x-layouts.app>