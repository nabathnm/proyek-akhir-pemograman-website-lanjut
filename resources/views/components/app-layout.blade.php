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
<body class="font-sans antialiased bg-gray-50 text-gray-900">
    <nav class="bg-white border-b border-gray-100 shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <a href="{{ url('/') }}" class="flex items-center gap-2 font-bold text-green-700 text-lg">
                    <span class="text-xl">🏠</span> EasyKos
                </a>

                <div class="hidden sm:flex items-center gap-1">
                    <a href="{{ route('home') }}"
                       class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('home', 'kosan.*') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-50' }}">
                        Beranda
                    </a>

                    @auth
                        @if(Auth::user()->role === 'pemilik')
                            <a href="{{ route('pemilik.dashboard') }}"
                               class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('pemilik.dashboard') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-50' }}">
                                Dashboard
                            </a>
                            <a href="{{ route('pemilik.kosan.index') }}"
                               class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('pemilik.kosan.*') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-50' }}">
                                Kosan Saya
                            </a>
                            <a href="{{ route('pemilik.pemesanan.index') }}"
                               class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('pemilik.pemesanan.*') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-50' }}">
                                Pemesanan
                            </a>
                        @else
                            <a href="{{ route('user.dashboard') }}"
                               class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('user.*') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-50' }}">
                                Pesanan Saya
                            </a>
                        @endif

                        <a href="{{ route('profile.edit') }}"
                           class="px-3 py-2 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50">
                            Profil
                        </a>

                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit"
                                    class="px-3 py-2 rounded-lg text-sm font-medium text-red-600 hover:bg-red-50">
                                Keluar
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}"
                           class="px-3 py-2 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}"
                           class="px-4 py-2 rounded-lg text-sm font-semibold text-white"
                           style="background:linear-gradient(135deg,#16a34a,#15803d)">
                            Daftar
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    @if(isset($header))
        <header class="bg-white shadow-sm border-b border-gray-100">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endif

    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg text-sm">
                {{ session('error') }}
            </div>
        </div>
    @endif

    <main>
        {{ $slot }}
    </main>
</body>
</html>
