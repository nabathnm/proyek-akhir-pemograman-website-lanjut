<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 text-sm text-gray-500">
            <a href="{{ route('user.dashboard') }}" class="hover:text-green-600 transition">Pesanan Saya</a>
            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-gray-800 font-semibold">Detail Pemesanan</span>
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

            {{-- Status Banner --}}
            @php
                $statusConfig = [
                    'pending' => ['bg' => 'bg-yellow-50', 'border' => 'border-yellow-200', 'text' => 'text-yellow-700', 'icon' => '⏳', 'label' => 'Menunggu Persetujuan'],
                    'disetujui' => ['bg' => 'bg-green-50', 'border' => 'border-green-200', 'text' => 'text-green-700', 'icon' => '✅', 'label' => 'Disetujui'],
                    'ditolak' => ['bg' => 'bg-red-50', 'border' => 'border-red-200', 'text' => 'text-red-700', 'icon' => '❌', 'label' => 'Ditolak'],
                    'dibatalkan' => ['bg' => 'bg-gray-50', 'border' => 'border-gray-200', 'text' => 'text-gray-500', 'icon' => '🚫', 'label' => 'Dibatalkan'],
                ];
                $sc = $statusConfig[$pemesanan->status] ?? $statusConfig['pending'];
            @endphp
            <div class="{{ $sc['bg'] }} {{ $sc['border'] }} border rounded-2xl p-5 flex items-center gap-4">
                <span class="text-3xl">{{ $sc['icon'] }}</span>
                <div>
                    <p class="font-bold {{ $sc['text'] }} text-lg">{{ $sc['label'] }}</p>
                    <p class="text-sm text-gray-500 mt-0.5">
                        @if($pemesanan->status === 'pending')
                            Pemesanan Anda sedang menunggu konfirmasi dari pemilik kosan.
                        @elseif($pemesanan->status === 'disetujui')
                            Pemesanan Anda telah disetujui! Silakan hubungi pemilik kosan untuk langkah selanjutnya.
                        @elseif($pemesanan->status === 'ditolak')
                            Maaf, pemesanan Anda ditolak oleh pemilik kosan. Silakan cari kosan lainnya.
                        @else
                            Pemesanan ini telah dibatalkan.
                        @endif
                    </p>
                </div>
            </div>

            {{-- Card: Info Kosan --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-800 text-base mb-4 pb-3 border-b border-gray-100">🏠 Informasi Kosan</h3>
                <div class="flex gap-4">
                    @if($pemesanan->kosan->fotoUtama)
                        <img src="{{ asset('storage/' . $pemesanan->kosan->fotoUtama->foto) }}" alt="{{ $pemesanan->kosan->nama_kosan }}"
                             class="w-28 h-20 object-cover rounded-xl border border-gray-100 shrink-0">
                    @else
                        <div class="w-28 h-20 bg-gray-100 rounded-xl flex items-center justify-center text-gray-300 shrink-0">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    @endif
                    <div class="min-w-0">
                        <a href="{{ route('kosan.show', $pemesanan->kosan) }}" class="font-bold text-gray-900 hover:text-green-700 transition truncate block">{{ $pemesanan->kosan->nama_kosan }}</a>
                        <p class="text-xs text-gray-500 flex items-center gap-1 mt-0.5">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            {{ $pemesanan->kosan->alamat }}, {{ $pemesanan->kosan->kota }}
                        </p>
                        <p class="text-xs text-gray-400 mt-0.5">Pemilik: {{ $pemesanan->kosan->pemilik->name ?? '-' }}</p>
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
                    @if($pemesanan->catatan)
                        <div class="flex justify-between py-2 border-b border-gray-50">
                            <span class="text-sm text-gray-500">Catatan</span>
                            <span class="text-sm text-gray-700 max-w-xs text-right">{{ $pemesanan->catatan }}</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Card: Ringkasan Biaya --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-800 text-base mb-4 pb-3 border-b border-gray-100">💰 Ringkasan Biaya</h3>
                <div class="space-y-3">
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>Harga per bulan</span>
                        <span class="font-semibold text-gray-800">Rp {{ number_format($pemesanan->kosan->harga_per_bulan, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>Durasi sewa</span>
                        <span class="font-semibold text-gray-800">{{ $pemesanan->durasi_bulan }} bulan</span>
                    </div>
                    <div class="border-t border-gray-100 pt-3 flex justify-between">
                        <span class="text-sm font-bold text-gray-800">Total Biaya</span>
                        <span class="text-lg font-extrabold text-green-700">Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex gap-3">
                <a href="{{ route('user.dashboard') }}"
                   class="flex-1 text-center py-3 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 text-sm font-semibold transition">
                    ← Kembali ke Dashboard
                </a>
                @if($pemesanan->status === 'pending')
                    <form method="POST" action="{{ route('user.pemesanan.destroy', $pemesanan) }}" class="flex-1"
                          onsubmit="return confirm('Yakin ingin membatalkan pemesanan ini?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="w-full py-3 rounded-xl border border-red-200 text-red-600 hover:bg-red-50 text-sm font-semibold transition">
                            Batalkan Pemesanan
                        </button>
                    </form>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
