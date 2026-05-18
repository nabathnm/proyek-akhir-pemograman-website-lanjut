<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-lg text-gray-800">Beranda — Daftar Kosan</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Search bar --}}
            <form method="GET" action="{{ route('kosan.search') }}" class="mb-6 flex gap-2">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari kosan, kota..."
                    class="flex-1 px-4 py-2 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent">
                <button type="submit" class="px-4 py-2 text-white text-sm font-semibold rounded-lg transition"
                    style="background:linear-gradient(135deg,#16a34a,#15803d)">Cari</button>
            </form>

            {{-- Grid kosan --}}
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @forelse($kosans as $kosan)
                    <a href="{{ route('kosan.show', $kosan) }}"
                        class="bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow overflow-hidden group">
                        {{-- Foto --}}
                        @if($kosan->fotoUtama)
                            <img src="{{ asset('storage/' . $kosan->fotoUtama->foto) }}" alt="{{ $kosan->nama_kosan }}"
                                class="w-full h-36 object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="w-full h-36 bg-gray-100 flex flex-col items-center justify-center text-gray-300">
                                <svg class="w-8 h-8 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-xs">Tidak ada foto</span>
                            </div>
                        @endif

                        {{-- Info --}}
                        <div class="p-3">
                            <div class="flex items-center justify-between mb-1">
                                <span
                                    class="text-xs px-1.5 py-0.5 rounded font-semibold
                                                    {{ $kosan->tipe === 'putra' ? 'bg-blue-50 text-blue-600' : ($kosan->tipe === 'putri' ? 'bg-pink-50 text-pink-600' : 'bg-purple-50 text-purple-600') }}">
                                    {{ ucfirst($kosan->tipe) }}
                                </span>
                                <span class="text-xs text-gray-400">{{ $kosan->kamar_tersedia }} kamar</span>
                            </div>
                            <h3 class="font-semibold text-gray-800 text-sm leading-tight truncate">{{ $kosan->nama_kosan }}
                            </h3>
                            <p class="text-xs text-gray-400 flex items-center gap-0.5 mt-0.5">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                {{ $kosan->kota }}
                            </p>
                            <p class="text-sm font-bold text-green-700 mt-2">
                                Rp {{ number_format($kosan->harga_per_bulan, 0, ',', '.') }}
                                <span class="text-xs font-normal text-gray-400">/bln</span>
                            </p>
                        </div>
                    </a>
                @empty
                    <div class="col-span-4 py-16 text-center text-gray-400">
                        <div class="text-5xl mb-3">🏠</div>
                        <p class="font-medium text-gray-600">Belum ada kosan tersedia</p>
                        <p class="text-sm mt-1">Coba ubah kata kunci pencarian</p>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($kosans->hasPages())
                <div class="mt-6">{{ $kosans->links() }}</div>
            @endif
        </div>
    </div>
</x-app-layout>