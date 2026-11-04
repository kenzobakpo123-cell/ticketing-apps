@props(['title', 'date', 'location', 'price', 'image', 'href' => null])

@php
    $formattedPrice = $price ? 'Rp ' . number_format($price, 0, ',', '.') : 'Harga tidak tersedia';
    $formattedDate = $date
        ? \Carbon\Carbon::parse($date)->locale('id')->translatedFormat('d F Y, H:i')
        : 'Tanggal tidak tersedia';

    $imageUrl = $image
        ? (filter_var($image, FILTER_VALIDATE_URL)
            ? $image
            : asset('images/events/' . $image))
        : asset('images/events/1769062679.jpg');
@endphp

<a href="{{ $href ?? '#' }}" class="group block h-full">
    <article class="h-full overflow-hidden rounded-[28px] border border-slate-200 bg-white shadow-[0_10px_25px_rgba(15,23,42,0.08)] transition duration-300 hover:-translate-y-1 hover:shadow-[0_20px_40px_rgba(37,99,235,0.16)]">
        <div class="relative h-56 overflow-hidden bg-slate-100">
            <img src="{{ $imageUrl }}" alt="{{ $title }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-slate-900/5 to-transparent"></div>
            <div class="absolute left-4 top-4 rounded-full bg-white/90 px-3 py-1 text-[10px] font-bold uppercase tracking-[0.18em] text-slate-700 shadow-sm">
                {{ $formattedDate }}
            </div>
        </div>

        <div class="space-y-4 p-5">
            <div class="flex items-start justify-between gap-3">
                <h2 class="line-clamp-2 text-xl font-black leading-snug text-slate-900">
                    {{ $title }}
                </h2>
                <span class="rounded-full bg-blue-50 px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.18em] text-blue-700">
                    Live
                </span>
            </div>

            <div class="flex items-center gap-2 text-sm text-slate-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span class="line-clamp-1">{{ $location }}</span>
            </div>

            <div class="flex items-end justify-between gap-3 border-t border-slate-100 pt-4">
                <div>
                    <div class="text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-400">Mulai dari</div>
                    <div class="mt-1 text-xl font-black text-slate-900">{{ $formattedPrice }}</div>
                </div>
                <span class="inline-flex items-center rounded-full bg-slate-900 px-3 py-2 text-xs font-semibold text-white transition group-hover:bg-blue-600">
                    Lihat detail
                </span>
            </div>
        </div>
    </article>
</a>