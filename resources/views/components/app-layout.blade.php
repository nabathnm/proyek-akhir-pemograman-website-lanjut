@props(['header' => null])

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'EasyKos') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="min-h-screen antialiased">
    <nav class="nb-nav sticky top-0 z-50">
        <div class="nb-shell py-3">
            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-2xl font-black tracking-tight md:text-3xl">
                    <span aria-hidden="true">▦</span> EasyKos
                </a>
                <div class="flex flex-wrap items-stretch gap-2 md:items-center md:justify-end">
                    <a href="{{ route('home') }}"
                       class="nb-nav-link w-full justify-start md:w-auto md:justify-center {{ request()->routeIs('home', 'kosan.*') ? 'is-active' : '' }}">
                        Beranda
                    </a>

                    @auth
                        @if(Auth::user()->role === 'pemilik')
                            <a href="{{ route('pemilik.dashboard') }}"
                               class="nb-nav-link w-full justify-start md:w-auto md:justify-center {{ request()->routeIs('pemilik.dashboard') ? 'is-active' : '' }}">
                                Dashboard
                            </a>
                            <a href="{{ route('pemilik.kosan.index') }}"
                               class="nb-nav-link w-full justify-start md:w-auto md:justify-center {{ request()->routeIs('pemilik.kosan.*') ? 'is-active' : '' }}">
                                Kosan Saya
                            </a>
                            <a href="{{ route('pemilik.pemesanan.index') }}"
                               class="nb-nav-link w-full justify-start md:w-auto md:justify-center {{ request()->routeIs('pemilik.pemesanan.*') ? 'is-active' : '' }}">
                                Pemesanan
                            </a>
                        @else
                            <a href="{{ route('user.dashboard') }}"
                               class="nb-nav-link w-full justify-start md:w-auto md:justify-center {{ request()->routeIs('user.*') ? 'is-active' : '' }}">
                                Pesanan Saya
                            </a>
                        @endif

                        <a href="{{ route('profile.edit') }}"
                           class="nb-nav-link w-full justify-start md:w-auto md:justify-center {{ request()->routeIs('profile.*') ? 'is-active' : '' }}">
                            Profil
                        </a>

                        <form method="POST" action="{{ route('logout') }}" class="w-full md:w-auto">
                            @csrf
                            <button type="submit" class="nb-btn nb-btn-danger w-full py-2 px-3 text-base md:w-auto">
                                Keluar
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="nb-nav-link w-full justify-start md:w-auto md:justify-center {{ request()->routeIs('login') ? 'is-active' : '' }}">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="nb-btn nb-btn-primary w-full py-2 px-3 text-base md:w-auto">
                            Daftar
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    @if(isset($header))
        <header class="bg-white py-4" style="border-bottom: 3px solid #111827;">
            <div class="nb-shell">
                {{ $header }}
            </div>
        </header>
    @endif

    @if(session('success'))
        <div class="nb-shell mt-4">
            <div class="nb-flash nb-flash-success">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="nb-shell mt-4">
            <div class="nb-flash nb-flash-error">
                {{ session('error') }}
            </div>
        </div>
    @endif

    <main class="pb-10">
        {{ $slot }}
    </main>
</body>
</html>
