<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800">Pesanan Saya</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm flex items-center gap-2">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Stats Cards --}}
            @php
                $totalPesanan = $pemesanans->count();
                $pending = $pemesanans->where('status', 'pending')->count();
                $disetujui = $pemesanans->where('status', 'disetujui')->count();
                $ditolak = $pemesanans->where('status', 'ditolak')->count();
            @endphp
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 text-center">
                    <p class="text-2xl font-extrabold text-gray-800">{{ $totalPesanan }}</p>
                    <p class="text-xs text-gray-500 mt-1">Total Pesanan</p>
                </div>
                <div class="bg-yellow-50 rounded-2xl border border-yellow-100 p-4 text-center">
                    <p class="text-2xl font-extrabold text-yellow-600">{{ $pending }}</p>
                    <p class="text-xs text-yellow-700 mt-1">Menunggu</p>
                </div>
                <div class="bg-green-50 rounded-2xl border border-green-100 p-4 text-center">
                    <p class="text-2xl font-extrabold text-green-600">{{ $disetujui }}</p>
                    <p class="text-xs text-green-700 mt-1">Disetujui</p>
                </div>
                <div class="bg-red-50 rounded-2xl border border-red-100 p-4 text-center">
                    <p class="text-2xl font-extrabold text-red-500">{{ $ditolak }}</p>
                    <p class="text-xs text-red-700 mt-1">Ditolak</p>
                </div>
            </div>

            {{-- Pemesanan List --}}
            @if($pemesanans->count())
                <div class="space-y-4">
                    @foreach($pemesanans as $pemesanan)
                        @php
                            $statusColors = [
                                'pending'    => 'bg-yellow-100 text-yellow-700',
                                'disetujui'  => 'bg-green-100 text-green-700',
                                'ditolak'    => 'bg-red-100 text-red-700',
                                'dibatalkan' => 'bg-gray-100 text-gray-500',
                            ];
                            $statusLabels = [
                                'pending'    => 'Menunggu',
                                'disetujui'  => 'Disetujui',
                                'ditolak'    => 'Ditolak',
                                'dibatalkan' => 'Dibatalkan',
                            ];
                        @endphp
                        <a href="{{ route('user.pemesanan.show', $pemesanan) }}"
                           class="block bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow overflow-hidden group">
                            <div class="flex flex-col sm:flex-row">
                                {{-- Foto --}}
                                <div class="sm:w-40 shrink-0">
                                    @if($pemesanan->kosan && $pemesanan->kosan->fotoUtama)
                                        <img src="{{ asset('storage/' . $pemesanan->kosan->fotoUtama->foto) }}"
                                             alt="{{ $pemesanan->kosan->nama_kosan }}"
                                             class="w-full h-32 sm:h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-32 sm:h-full bg-gray-100 flex items-center justify-center text-gray-300">
                                            <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                {{-- Info --}}
                                <div class="flex-1 p-5 flex flex-col justify-between">
                                    <div>
                                        <div class="flex items-start justify-between gap-3 mb-2">
                                            <div>
                                                <h3 class="font-bold text-gray-900 group-hover:text-green-700 transition-colors">{{ $pemesanan->kosan->nama_kosan ?? 'Kosan Dihapus' }}</h3>
                                                <p class="text-xs text-gray-500 mt-0.5">{{ $pemesanan->kosan->alamat ?? '' }}, {{ $pemesanan->kosan->kota ?? '' }}</p>
                                            </div>
                                            <span class="text-xs px-2.5 py-1 rounded-full font-semibold shrink-0 {{ $statusColors[$pemesanan->status] ?? 'bg-gray-100 text-gray-500' }}">
                                                {{ $statusLabels[$pemesanan->status] ?? ucfirst($pemesanan->status) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between mt-3 pt-3 border-t border-gray-100">
                                        <div class="flex items-center gap-4 text-xs text-gray-500">
                                            <span class="flex items-center gap-1">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                {{ \Carbon\Carbon::parse($pemesanan->tanggal_masuk)->translatedFormat('d M Y') }}
                                            </span>
                                            <span>{{ $pemesanan->durasi_bulan }} bulan</span>
                                        </div>
                                        <span class="font-bold text-green-700 text-sm">Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                    <div class="w-16 h-16 rounded-full bg-gray-50 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-800 text-lg mb-1">Belum Ada Pesanan</h3>
                    <p class="text-sm text-gray-500 mb-5">Anda belum pernah mengajukan pemesanan kosan. Mulai cari kosan impianmu!</p>
                    <a href="{{ route('home') }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-white text-sm font-semibold transition hover:shadow-md"
                       style="background: linear-gradient(135deg, #16a34a, #15803d);">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Cari Kosan
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
