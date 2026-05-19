<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('pemilik.kosan.index') }}" class="text-gray-400 hover:text-gray-600 transition">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <h2 class="font-bold text-xl text-gray-800">Detail Kosan</h2>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('pemilik.kosan.edit', $kosan) }}"
                    class="inline-flex items-center gap-1.5 text-sm font-semibold px-4 py-2 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-700 transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
                <form action="{{ route('pemilik.kosan.destroy', $kosan) }}" method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus kosan ini? Tindakan ini tidak dapat dibatalkan.')">
                    @csrf @method('DELETE')
                    <button type="submit"
                        class="inline-flex items-center gap-1.5 text-sm font-semibold px-4 py-2 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 transition">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Galeri Foto --}}
            @if($kosan->fotos->count())
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    {{-- Foto utama besar --}}
                    @php $fotoUtama = $kosan->fotos->firstWhere('is_utama', true) ?? $kosan->fotos->first(); @endphp
                    <img src="{{ asset('storage/' . $fotoUtama->foto) }}" alt="{{ $kosan->nama_kosan }}"
                        class="w-full h-72 object-cover">

                    {{-- Thumbnail --}}
                    @if($kosan->fotos->count() > 1)
                        <div class="flex gap-2 p-3 overflow-x-auto">
                            @foreach($kosan->fotos as $foto)
                                <img src="{{ asset('storage/' . $foto->foto) }}" alt="Foto"
                                    class="h-16 w-24 object-cover rounded-lg flex-shrink-0 border-2 {{ $foto->is_utama ? 'border-green-500' : 'border-gray-100' }}">
                            @endforeach
                        </div>
                    @endif
                </div>
            @else
                <div
                    class="bg-white rounded-2xl shadow-sm border border-gray-100 h-56 flex items-center justify-center text-gray-300">
                    <div class="text-center">
                        <svg class="w-12 h-12 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="text-sm">Belum ada foto</p>
                    </div>
                </div>
            @endif

            {{-- Info Utama --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">{{ $kosan->nama_kosan }}</h3>
                        <p class="text-gray-400 text-sm flex items-center gap-1 mt-1">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ $kosan->alamat }}, {{ $kosan->kota }}
                        </p>
                    </div>
                    <span
                        class="px-3 py-1 rounded-full text-xs font-semibold {{ $kosan->status === 'aktif' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ ucfirst($kosan->status) }}
                    </span>
                </div>

                <div class="grid grid-cols-3 gap-4 py-4 border-y border-gray-100 mb-4">
                    <div class="text-center">
                        <p class="text-2xl font-bold text-green-700">Rp
                            {{ number_format($kosan->harga_per_bulan, 0, ',', '.') }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">per bulan</p>
                    </div>
                    <div class="text-center border-x border-gray-100">
                        <p class="text-2xl font-bold text-gray-800">
                            {{ $kosan->kamar_tersedia }}/{{ $kosan->jumlah_kamar }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">kamar tersedia</p>
                    </div>
                    <div class="text-center">
                        <p class="text-2xl font-bold text-gray-800 capitalize">{{ $kosan->tipe }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">tipe kosan</p>
                    </div>
                </div>

                <h4 class="font-semibold text-gray-700 mb-2">Deskripsi</h4>
                <p class="text-sm text-gray-600 leading-relaxed">{{ $kosan->deskripsi }}</p>
            </div>

            {{-- Fasilitas --}}
            @if(!empty($kosan->fasilitas))
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h4 class="font-semibold text-gray-800 mb-4">✅ Fasilitas</h4>
                    <div class="flex flex-wrap gap-2">
                        @foreach($kosan->fasilitas as $f)
                            <span
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-green-50 text-green-700 text-sm rounded-lg font-medium border border-green-100">
                                ✓ {{ $f }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>