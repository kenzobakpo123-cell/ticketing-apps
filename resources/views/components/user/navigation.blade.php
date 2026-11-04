<div class="sticky top-0 z-50 border-b border-slate-200 bg-white/80 backdrop-blur-xl">
    <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-3">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="{{ asset('assets/images/bengtix-logo.svg') }}" alt="BengTix — Events made easy" class="h-12 w-auto">
            </a>
        </div>

        <form action="{{ route('home') }}" method="GET" class="hidden flex-1 justify-center lg:flex">
            <label class="relative block w-full max-w-xl">
                <span class="sr-only">Cari event</span>
                <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari event, kota, atau kategori..."
                    class="w-full rounded-full border border-slate-200 bg-slate-50 py-3 pl-12 pr-4 text-sm text-slate-700 shadow-inner shadow-slate-200/60 transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100">
                <svg class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 100-15 7.5 7.5 0 000 15z" />
                </svg>
            </label>
        </form>

        <div class="flex items-center gap-3">
            @guest
                <a href="{{ route('login') }}" class="hidden rounded-full border border-blue-600 px-4 py-2 text-sm font-semibold text-blue-700 transition hover:bg-blue-50 sm:inline-flex">Login</a>
                <a href="{{ route('register') }}" class="inline-flex rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-slate-900/20 transition hover:-translate-y-0.5 hover:bg-slate-800">Register</a>
            @endguest

            @auth
                <div class="dropdown dropdown-end">
                    <div tabindex="0" role="button" class="btn btn-ghost rounded-full border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-700 shadow-sm hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700">
                        {{ Auth::user()->name }}
                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                    <ul tabindex="0" class="menu dropdown-content z-[1] mt-3 w-52 rounded-2xl border border-slate-200 bg-white p-2 text-slate-700 shadow-xl">
                        <li>
                            <a href="{{ route('orders.index') }}" class="rounded-xl px-3 py-2 hover:bg-slate-100">Riwayat Pembelian</a>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}" class="rounded-xl px-3 py-2 hover:bg-slate-100"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            @endauth
        </div>
    </div>
</div>