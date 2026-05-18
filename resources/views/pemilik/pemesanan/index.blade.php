<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800">Kelola Pemesanan</h2>
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
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                            <div class="flex flex-col sm:flex-row">
                                {{-- Foto --}}
                                <div class="sm:w-36 shrink-0">
                                    @if($pemesanan->kosan && $pemesanan->kosan->fotoUtama)
                                        <img src="{{ asset('storage/' . $pemesanan->kosan->fotoUtama->foto) }}"
                                             alt="{{ $pemesanan->kosan->nama_kosan }}"
                                             class="w-full h-28 sm:h-full object-cover">
                                    @else
                                        <div class="w-full h-28 sm:h-full bg-gray-100 flex items-center justify-center text-gray-300">
                                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                {{-- Info --}}
                                <div class="flex-1 p-5">
                                    <div class="flex items-start justify-between gap-3 mb-3">
                                        <div>
                                            <h3 class="font-bold text-gray-900">{{ $pemesanan->kosan->nama_kosan ?? '-' }}</h3>
                                            <p class="text-xs text-gray-500 mt-0.5">Oleh: <span class="font-semibold text-gray-700">{{ $pemesanan->user->name ?? '-' }}</span> — {{ $pemesanan->user->email ?? '' }}</p>
                                        </div>
                                        <span class="text-xs px-2.5 py-1 rounded-full font-semibold shrink-0 {{ $statusColors[$pemesanan->status] ?? 'bg-gray-100 text-gray-500' }}">
                                            {{ $statusLabels[$pemesanan->status] ?? ucfirst($pemesanan->status) }}
                                        </span>
                                    </div>

                                    <div class="flex flex-wrap items-center gap-4 text-xs text-gray-500 mb-4">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            Masuk: {{ \Carbon\Carbon::parse($pemesanan->tanggal_masuk)->translatedFormat('d M Y') }}
                                        </span>
                                        <span>{{ $pemesanan->durasi_bulan }} bulan</span>
                                        <span class="font-bold text-green-700">Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }}</span>
                                    </div>

                                    {{-- Actions --}}
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <a href="{{ route('pemilik.pemesanan.show', $pemesanan) }}"
                                           class="text-xs px-3 py-1.5 rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-50 font-semibold transition">
                                            Detail
                                        </a>
                                        @if($pemesanan->status === 'pending')
                                            <form method="POST" action="{{ route('pemilik.pemesanan.setujui', $pemesanan) }}" class="inline">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="text-xs px-3 py-1.5 rounded-lg bg-green-600 text-white font-semibold hover:bg-green-700 transition">
                                                    ✓ Setujui
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('pemilik.pemesanan.tolak', $pemesanan) }}" class="inline"
                                                  onsubmit="return confirm('Yakin ingin menolak pemesanan ini?')">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="text-xs px-3 py-1.5 rounded-lg bg-red-50 text-red-600 font-semibold hover:bg-red-100 transition border border-red-200">
                                                    ✗ Tolak
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $pemesanans->links() }}
                </div>
            @else
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                    <div class="w-16 h-16 rounded-full bg-gray-50 flex items-center justify-center mx-auto mb-4">
                    </div>
                    <h3 class="font-bold text-gray-800 text-lg mb-1">Belum Ada Pemesanan</h3>
                    <p class="text-sm text-gray-500">Belum ada pengguna yang mengajukan pemesanan untuk kosan Anda.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
