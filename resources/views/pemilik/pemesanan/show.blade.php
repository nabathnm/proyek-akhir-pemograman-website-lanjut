<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 text-sm text-gray-500">
            <a href="{{ route('pemilik.pemesanan.index') }}" class="hover:text-green-600 transition">Kelola Pemesanan</a>
            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-gray-800 font-semibold">Detail Pemesanan #{{ str_pad($pemesanan->id, 5, '0', STR_PAD_LEFT) }}</span>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm flex items-center gap-2">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Status Banner --}}
            @php
                $statusConfig = [
                    'pending' => ['bg' => 'bg-yellow-50', 'border' => 'border-yellow-200', 'text' => 'text-yellow-700', 'icon' => '⏳', 'label' => 'Menunggu Persetujuan'],
                    'disetujui' => ['bg' => 'bg-green-50', 'border' => 'border-green-200', 'text' => 'text-green-700', 'icon' => '✅', 'label' => 'Disetujui'],
                    'ditolak' => ['bg' => 'bg-red-50', 'border' => 'border-red-200', 'text' => 'text-red-700', 'icon' => '❌', 'label' => 'Ditolak'],
                    'dibatalkan' => ['bg' => 'bg-gray-50', 'border' => 'border-gray-200', 'text' => 'text-gray-500', 'icon' => '🚫', 'label' => 'Dibatalkan oleh Penyewa'],
                ];
                $sc = $statusConfig[$pemesanan->status] ?? $statusConfig['pending'];
            @endphp
            <div class="{{ $sc['bg'] }} {{ $sc['border'] }} border rounded-2xl p-5 flex items-center gap-4">
                <span class="text-3xl">{{ $sc['icon'] }}</span>
                <div>
                    <p class="font-bold {{ $sc['text'] }} text-lg">{{ $sc['label'] }}</p>
                    <p class="text-sm text-gray-500 mt-0.5">
                        @if($pemesanan->status === 'pending')
                            Pemesanan ini menunggu keputusan Anda untuk disetujui atau ditolak.
                        @elseif($pemesanan->status === 'disetujui')
                            Anda telah menyetujui pemesanan ini. Kamar tersedia telah dikurangi.
                        @elseif($pemesanan->status === 'ditolak')
                            Anda telah menolak pemesanan ini.
                        @else
                            Pemesanan ini telah dibatalkan oleh penyewa.
                        @endif
                    </p>
                </div>
            </div>

            {{-- Card: Info Penyewa --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-800 text-base mb-4 pb-3 border-b border-gray-100">👤 Informasi Penyewa</h3>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-bold text-lg shrink-0">
                        {{ strtoupper(substr($pemesanan->user->name ?? '?', 0, 1)) }}
                    </div>
                    <div>
                        <p class="font-bold text-gray-900">{{ $pemesanan->user->name ?? '-' }}</p>
                        <p class="text-sm text-gray-500">{{ $pemesanan->user->email ?? '-' }}</p>
                        @if($pemesanan->user->no_hp)
                            <p class="text-sm text-gray-500">📞 {{ $pemesanan->user->no_hp }}</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Card: Info Kosan --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-800 text-base mb-4 pb-3 border-b border-gray-100">🏠 Kosan yang Dipesan</h3>
                <div class="flex gap-4">
                    @if($pemesanan->kosan->fotoUtama)
                        <img src="{{ asset('storage/' . $pemesanan->kosan->fotoUtama->foto) }}" alt="{{ $pemesanan->kosan->nama_kosan }}"
                             class="w-28 h-20 object-cover rounded-xl border border-gray-100 shrink-0">
                    @endif
                    <div>
                        <a href="{{ route('pemilik.kosan.show', $pemesanan->kosan) }}" class="font-bold text-gray-900 hover:text-green-700 transition">{{ $pemesanan->kosan->nama_kosan }}</a>
                        <p class="text-xs text-gray-500 mt-0.5">{{ $pemesanan->kosan->alamat }}, {{ $pemesanan->kosan->kota }}</p>
                        <p class="text-sm font-bold text-green-700 mt-1">Rp {{ number_format($pemesanan->kosan->harga_per_bulan, 0, ',', '.') }} / bulan</p>
                    </div>
                </div>
            </div>

            {{-- Card: Detail Pemesanan --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-800 text-base mb-4 pb-3 border-b border-gray-100">📋 Detail Pemesanan</h3>
                <div class="space-y-3">
                    <div class="flex justify-between py-2 border-b border-gray-50">
                        <span class="text-sm text-gray-500">No. Pemesanan</span>
                        <span class="text-sm font-bold text-gray-800">#{{ str_pad($pemesanan->id, 5, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-50">
                        <span class="text-sm text-gray-500">Tanggal Pesan</span>
                        <span class="text-sm font-semibold text-gray-800">{{ $pemesanan->created_at->translatedFormat('d F Y, H:i') }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-50">
                        <span class="text-sm text-gray-500">Tanggal Masuk</span>
                        <span class="text-sm font-semibold text-gray-800">{{ \Carbon\Carbon::parse($pemesanan->tanggal_masuk)->translatedFormat('d F Y') }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-50">
                        <span class="text-sm text-gray-500">Durasi Sewa</span>
                        <span class="text-sm font-semibold text-gray-800">{{ $pemesanan->durasi_bulan }} Bulan</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-50">
                        <span class="text-sm text-gray-500">Total Biaya</span>
                        <span class="text-sm font-extrabold text-green-700">Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }}</span>
                    </div>
                    @if($pemesanan->catatan)
                        <div class="py-2">
                            <span class="text-sm text-gray-500 block mb-1">Catatan dari Penyewa</span>
                            <p class="text-sm text-gray-700 bg-gray-50 rounded-lg p-3 italic">"{{ $pemesanan->catatan }}"</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex gap-3">
                <a href="{{ route('pemilik.pemesanan.index') }}"
                   class="flex-1 text-center py-3 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 text-sm font-semibold transition">
                    ← Kembali
                </a>
                @if($pemesanan->status === 'pending')
                    <form method="POST" action="{{ route('pemilik.pemesanan.setujui', $pemesanan) }}" class="flex-1">
                        @csrf @method('PATCH')
                        <button type="submit"
                                class="w-full py-3 rounded-xl text-white font-bold text-sm transition shadow-sm hover:shadow-md"
                                style="background: linear-gradient(135deg, #16a34a, #15803d);">
                            ✓ Setujui Pemesanan
                        </button>
                    </form>
                    <form method="POST" action="{{ route('pemilik.pemesanan.tolak', $pemesanan) }}" class="flex-1"
                          onsubmit="return confirm('Yakin ingin menolak pemesanan ini?')">
                        @csrf @method('PATCH')
                        <button type="submit"
                                class="w-full py-3 rounded-xl border border-red-200 text-red-600 hover:bg-red-50 font-bold text-sm transition">
                            ✗ Tolak Pemesanan
                        </button>
                    </form>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
