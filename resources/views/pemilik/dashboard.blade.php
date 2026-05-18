<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800">Dashboard</h2>
    </x-slot>

    <style>
        .hero-gradient {
            background: linear-gradient(135deg, #16a34a 0%, #15803d 50%, #166534 100%);
        }
        .stat-card {
            transition: all 0.25s cubic-bezier(.4,0,.2,1);
        }
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 32px -6px rgba(0,0,0,0.10);
        }
        .kosan-card {
            transition: all 0.3s cubic-bezier(.4,0,.2,1);
        }
        .kosan-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px -10px rgba(22,163,74,0.18);
        }
        .kosan-card img {
            transition: transform 0.5s ease;
        }
        .kosan-card:hover img {
            transform: scale(1.07);
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .anim-in { animation: fadeInUp 0.45s ease both; }
        .anim-in-1 { animation-delay: 0.05s; }
        .anim-in-2 { animation-delay: 0.10s; }
        .anim-in-3 { animation-delay: 0.15s; }
        .anim-in-4 { animation-delay: 0.20s; }
        .anim-in-5 { animation-delay: 0.25s; }
        .pulse-dot {
            width: 8px; height: 8px; border-radius: 50%;
            background: #22c55e;
            animation: pulse-ring 1.5s ease-in-out infinite;
        }
        @keyframes pulse-ring {
            0%,100% { box-shadow: 0 0 0 0 rgba(34,197,94,0.5); }
            50%      { box-shadow: 0 0 0 6px rgba(34,197,94,0); }
        }
    </style>

    <div class="py-6">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 space-y-6">

            {{-- Hero Banner --}}
            <div class="hero-gradient rounded-2xl p-6 sm:p-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-5 anim-in shadow-lg overflow-hidden relative">
                {{-- Decorative circles --}}
                <div class="absolute -top-8 -right-8 w-40 h-40 rounded-full bg-white/5 pointer-events-none"></div>
                <div class="absolute -bottom-10 -left-6 w-52 h-52 rounded-full bg-white/5 pointer-events-none"></div>

                <div class="relative z-10">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="pulse-dot"></div>
                        <span class="text-green-200 text-xs font-semibold tracking-wide uppercase">Pemilik Kos</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-white leading-tight">
                        Selamat datang, {{ Auth::user()->name }}! 👋
                    </h1>
                    <p class="text-green-100 text-sm mt-1">
                        Kelola, pantau, dan optimalkan kosan Anda dari satu tempat.
                    </p>
                </div>
                <div class="relative z-10 shrink-0">
                    <a href="{{ route('pemilik.kosan.create') }}"
                       class="inline-flex items-center gap-2 px-5 py-3 bg-white text-green-700 text-sm font-bold rounded-xl shadow-md hover:bg-green-50 transition-all duration-200 hover:shadow-lg active:scale-95">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Kosan
                    </a>
                </div>
            </div>

            {{-- Stats Cards --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

                {{-- Total Kosan --}}
                <div class="stat-card anim-in anim-in-1 bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex flex-col gap-3">
                    <div class="flex items-center justify-between">
                        <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 9.75L12 4l9 5.75V20a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9.75z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 21V12h6v9"/>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-0.5 rounded-full">Kosan</span>
                    </div>
                    <div>
                        <p class="text-3xl font-extrabold text-gray-900 leading-none">{{ $totalKosan ?? 0 }}</p>
                        <p class="text-xs text-gray-400 mt-1">Total Kosan</p>
                    </div>
                </div>

                {{-- Total Pesanan --}}
                <div class="stat-card anim-in anim-in-2 bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex flex-col gap-3">
                    <div class="flex items-center justify-between">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full">Pesanan</span>
                    </div>
                    <div>
                        <p class="text-3xl font-extrabold text-gray-900 leading-none">{{ $totalPemesanan ?? 0 }}</p>
                        <p class="text-xs text-gray-400 mt-1">Total Pesanan</p>
                    </div>
                </div>

                {{-- Pending --}}
                <div class="stat-card anim-in anim-in-3 bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex flex-col gap-3">
                    <div class="flex items-center justify-between">
                        <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        @if(($pemesananPending ?? 0) > 0)
                            <span class="text-xs font-bold text-amber-600 bg-amber-50 px-2 py-0.5 rounded-full animate-pulse">Baru!</span>
                        @else
                            <span class="text-xs font-semibold text-amber-600 bg-amber-50 px-2 py-0.5 rounded-full">Pending</span>
                        @endif
                    </div>
                    <div>
                        <p class="text-3xl font-extrabold text-gray-900 leading-none">{{ $pemesananPending ?? 0 }}</p>
                        <p class="text-xs text-gray-400 mt-1">Menunggu Konfirmasi</p>
                    </div>
                </div>

                {{-- Kamar Tersedia --}}
                <div class="stat-card anim-in anim-in-4 bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex flex-col gap-3">
                    <div class="flex items-center justify-between">
                        <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-purple-600 bg-purple-50 px-2 py-0.5 rounded-full">Kamar</span>
                    </div>
                    <div>
                        <p class="text-3xl font-extrabold text-gray-900 leading-none">{{ $totalKamarTersedia ?? 0 }}</p>
                        <p class="text-xs text-gray-400 mt-1">Kamar Tersedia</p>
                    </div>
                </div>

            </div>

                {{-- Kosan Terbaru --}}
                <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-bold text-gray-800 text-sm">Kosan Saya</h3>
                        <a href="{{ route('pemilik.kosan.index') }}"
                           class="text-xs text-green-600 hover:text-green-800 font-semibold flex items-center gap-1 transition-colors">
                            Lihat Semua
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>

                    @if(isset($kosanTerbaru) && $kosanTerbaru->count())
                        <div class="space-y-2.5">
                            @foreach($kosanTerbaru->take(4) as $kosan)
                                <a href="{{ route('pemilik.kosan.show', $kosan) }}"
                                   class="kosan-card flex items-center gap-3 p-3 rounded-xl border border-gray-100 hover:border-green-200 bg-white hover:bg-green-50/30 group overflow-hidden block">

                                    {{-- Thumbnail --}}
                                    <div class="w-16 h-14 rounded-lg overflow-hidden shrink-0 bg-gray-100">
                                        @if($kosan->fotoUtama)
                                            <img src="{{ asset('storage/' . $kosan->fotoUtama->foto) }}"
                                                 alt="{{ $kosan->nama_kosan }}"
                                                 class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <svg class="w-5 h-5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Info --}}
                                    <div class="flex-1 min-w-0">
                                        <p class="font-semibold text-gray-800 text-sm truncate">{{ $kosan->nama_kosan }}</p>
                                        <p class="text-xs text-gray-400 mt-0.5 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            </svg>
                                            {{ $kosan->kota }}
                                        </p>
                                        <p class="text-xs font-bold text-green-700 mt-0.5">Rp {{ number_format($kosan->harga_per_bulan, 0, ',', '.') }}<span class="font-normal text-gray-400">/bln</span></p>
                                    </div>

                                    {{-- Badge --}}
                                    <div class="shrink-0 text-right">
                                        <span class="inline-block px-2 py-0.5 rounded-full text-xs font-semibold
                                            {{ $kosan->status === 'aktif' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                            {{ ucfirst($kosan->status) }}
                                        </span>
                                        <p class="text-xs text-gray-400 mt-1">{{ $kosan->kamar_tersedia }}/{{ $kosan->jumlah_kamar }} kamar</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center py-12 text-center">
                            <div class="w-16 h-16 rounded-2xl bg-green-50 flex items-center justify-center mb-4">
                                <span class="text-3xl">🏡</span>
                            </div>
                            <p class="text-sm font-semibold text-gray-700 mb-1">Belum ada kosan</p>
                            <p class="text-xs text-gray-400 mb-4">Mulai tambahkan kosan pertama Anda</p>
                            <a href="{{ route('pemilik.kosan.create') }}"
                               class="inline-flex items-center gap-1.5 px-4 py-2 text-white text-xs font-bold rounded-lg transition hover:opacity-90"
                               style="background: linear-gradient(135deg,#22c55e,#16a34a)">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                </svg>
                                Tambah Kosan
                            </a>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
