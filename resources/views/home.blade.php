<x-layouts.app>
    <div class="relative overflow-hidden bg-gradient-to-br from-slate-950 via-blue-950 to-indigo-900 text-white">
        <div class="absolute inset-0 opacity-30">
            <div class="absolute left-0 top-0 h-72 w-72 rounded-full bg-blue-500/30 blur-3xl"></div>
            <div class="absolute bottom-0 right-0 h-96 w-96 rounded-full bg-fuchsia-500/20 blur-3xl"></div>
        </div>

        <div class="relative mx-auto grid max-w-7xl gap-10 px-6 py-16 lg:grid-cols-[1.2fr_0.8fr] lg:items-center lg:py-24">
            <div>
                <div class="mb-6 inline-flex items-center rounded-full border border-white/20 bg-white/10 px-3 py-1.5 text-xs font-semibold uppercase tracking-[0.2em] text-blue-100">
                    Event paling rame di satu tempat
                </div>
                <h1 class="max-w-xl text-4xl font-black leading-tight tracking-tight text-white md:text-5xl lg:text-6xl">
                    Beli tiket acara favoritmu tanpa ribet.
                </h1>
                <p class="mt-5 max-w-xl text-base text-blue-100 md:text-lg">
                    Jelajahi konser, seminar, festival, hingga workshop terbaru. Pilih kategori, cari event, dan booking tiket dalam hitungan menit.
                </p>

                <form action="{{ route('home') }}" method="GET" class="mt-8 flex max-w-xl flex-col gap-3 rounded-[28px] border border-white/10 bg-white/10 p-3 backdrop-blur-md sm:flex-row">
                    <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari event, kota, atau kategori..."
                        class="w-full rounded-full border border-transparent bg-white/10 px-5 py-3.5 text-sm text-white placeholder:text-blue-100 focus:border-blue-200 focus:outline-none focus:ring-4 focus:ring-blue-200/30">
                    <button type="submit" class="inline-flex items-center justify-center rounded-full bg-white px-6 py-3 text-sm font-bold text-slate-900 transition hover:bg-blue-100">
                        Cari Event
                    </button>
                </form>

                <div class="mt-8 flex flex-wrap gap-6 text-sm text-blue-100">
                    <div>
                        <div class="text-2xl font-black text-white">{{ number_format($stats['tickets']) }}</div>
                        <div>Tiket tersedia</div>
                    </div>
                    <div>
                        <div class="text-2xl font-black text-white">{{ number_format($stats['events']) }}</div>
                        <div>Event mendatang</div>
                    </div>
                    <div>
                        <div class="text-2xl font-black text-white">{{ number_format($stats['categories']) }}</div>
                        <div>Kategori acara</div>
                    </div>
                </div>
            </div>

            <div class="relative">
                @if($featuredEvent)
                    <div class="soft-card overflow-hidden bg-white/5 p-3 shadow-[0_24px_80px_rgba(59,130,246,0.35)] ring-1 ring-white/10">
                        <div class="overflow-hidden rounded-[24px]">
                            @php
                                $heroImage = $featuredEvent->gambar
                                    ? (filter_var($featuredEvent->gambar, FILTER_VALIDATE_URL)
                                        ? $featuredEvent->gambar
                                        : asset('images/events/' . $featuredEvent->gambar))
                                    : asset('images/events/1769062679.jpg');
                            @endphp
                            <img src="{{ $heroImage }}" alt="{{ $featuredEvent->judul }}" class="h-[420px] w-full object-cover">
                        </div>
                        <div class="mt-4 rounded-[22px] bg-white p-5 text-slate-900 shadow-lg">
                            <div class="flex items-center justify-between gap-3">
                                <span class="rounded-full bg-blue-100 px-3 py-1 text-[10px] font-bold uppercase tracking-[0.2em] text-blue-700">Featured</span>
                                <span class="text-sm font-semibold text-slate-500">{{ \Carbon\Carbon::parse($featuredEvent->tanggal_waktu)->locale('id')->translatedFormat('d M Y') }}</span>
                            </div>
                            <h2 class="mt-3 text-2xl font-black leading-tight">{{ $featuredEvent->judul }}</h2>
                            <p class="mt-2 text-sm text-slate-500">{{ $featuredEvent->lokasi }}</p>
                            <div class="mt-4 flex items-center justify-between">
                                <div>
                                    <div class="text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-400">Mulai dari</div>
                                    <div class="mt-1 text-2xl font-black text-slate-900">
                                        Rp {{ number_format($featuredEvent->tikets->min('harga') ?? 0, 0, ',', '.') }}
                                    </div>
                                </div>
                                <a href="{{ route('events.show', $featuredEvent) }}" class="inline-flex rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-600">
                                    Lihat detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <section class="mx-auto max-w-7xl px-6 py-8">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 class="section-title">Kategori favorit</h2>
            <a href="{{ route('home') }}" class="text-sm font-semibold text-blue-700 underline-offset-4 hover:underline">Lihat semua</a>
        </div>

        <div class="mt-5 flex flex-wrap gap-3">
            <a href="{{ route('home') }}"
               class="inline-flex items-center rounded-full border px-4 py-2 text-sm font-medium transition {{ !request('kategori') ? 'border-blue-600 bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'border-slate-200 bg-white text-slate-700 hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700' }}">
                Semua
            </a>
            @foreach($categories as $kategori)
                <a href="{{ route('home', ['kategori' => $kategori->id, 'q' => request('q')]) }}"
                   class="inline-flex items-center rounded-full border px-4 py-2 text-sm font-medium transition {{ request('kategori') == $kategori->id ? 'border-blue-600 bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'border-slate-200 bg-white text-slate-700 hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700' }}">
                    {{ $kategori->nama }}
                </a>
            @endforeach
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-6 py-12">
        <div class="mb-8 flex items-center justify-between gap-3">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.22em] text-blue-700">Event terbaru</p>
                <h2 class="mt-2 section-title">Jelajahi acara yang siap kamu ikuti</h2>
            </div>
        </div>

        @if($events->isEmpty())
            <div class="soft-card flex flex-col items-center justify-center gap-3 px-6 py-16 text-center">
                <div class="flex h-16 w-16 items-center justify-center rounded-full bg-blue-100 text-3xl">🎟️</div>
                <h3 class="text-2xl font-black text-slate-900">Event tidak ditemukan</h3>
                <p class="max-w-md text-slate-500">Coba ubah kata kunci pencarian atau pilih kategori lain untuk menemukan event yang cocok.</p>
                <a href="{{ route('home') }}" class="mt-2 inline-flex rounded-full bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-600">Reset pencarian</a>
            </div>
        @else
            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                @foreach($events as $event)
                    <x-user.event-card :title="$event->judul" :date="$event->tanggal_waktu" :location="$event->lokasi"
                        :price="$event->tikets_min_harga" :image="$event->gambar" :href="route('events.show', $event)" />
                @endforeach
            </div>
        @endif
    </section>

    <section class="bg-slate-100/80 py-16">
        <div class="mx-auto max-w-7xl px-6">
            <div class="mx-auto max-w-2xl text-center">
                <p class="text-sm font-semibold uppercase tracking-[0.22em] text-blue-700">Kenapa pilih BengTix</p>
                <h2 class="mt-3 section-title">Booking tiket jadi lebih cepat, aman, dan memorable.</h2>
            </div>

            <div class="mt-10 grid gap-6 md:grid-cols-3">
                <div class="soft-card p-6">
                    <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-100 text-xl">⚡</div>
                    <h3 class="text-xl font-black text-slate-900">Proses cepat</h3>
                    <p class="mt-2 text-sm leading-6 text-slate-600">Pilih event, atur jumlah tiket, dan checkout dalam hitungan menit tanpa antre.</p>
                </div>
                <div class="soft-card p-6">
                    <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-100 text-xl">🔒</div>
                    <h3 class="text-xl font-black text-slate-900">Aman dan terpercaya</h3>
                    <p class="mt-2 text-sm leading-6 text-slate-600">Semua transaksi dan data pengguna dirancang agar lebih aman dan terorganisir.</p>
                </div>
                <div class="soft-card p-6">
                    <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-fuchsia-100 text-xl">🎉</div>
                    <h3 class="text-xl font-black text-slate-900">Event pilihan</h3>
                    <p class="mt-2 text-sm leading-6 text-slate-600">Dapatkan akses ke event terpopuler dan kategori beragam dari musik, komunitas, hingga seminar.</p>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>