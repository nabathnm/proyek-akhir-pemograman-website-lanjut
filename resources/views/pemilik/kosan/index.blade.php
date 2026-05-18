<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">
                    Kelola Kosan
                </h2>
                <p class="text-sm text-gray-400 mt-1">
                    Kelola dan pantau semua kosan Anda dengan mudah
                </p>
            </div>

            <a href="{{ route('pemilik.kosan.create') }}"
               class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-2xl text-sm font-semibold text-white shadow-lg hover:scale-[1.02] transition-all duration-200"
               style="background: linear-gradient(135deg,#22c55e,#16a34a)">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Kosan
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">

            {{-- Success Alert --}}
            @if(session('success'))
                <div class="mb-6 flex items-center gap-3 bg-green-50 border border-green-100 text-green-700 px-4 py-3 rounded-2xl shadow-sm">
                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>

                    <div>
                        <p class="font-semibold text-sm">Berhasil</p>
                        <p class="text-sm text-green-600">
                            {{ session('success') }}
                        </p>
                    </div>
                </div>
            @endif

            {{-- Empty State --}}
            @if($kosans->isEmpty())
                <div class="bg-white border border-gray-100 rounded-3xl shadow-sm py-20 px-6 text-center">

                    <div class="w-24 h-24 mx-auto rounded-full bg-green-50 flex items-center justify-center mb-6">
                        <span class="text-5xl">🏡</span>
                    </div>

                    <h3 class="text-xl font-bold text-gray-800 mb-2">
                        Belum Ada Kosan
                    </h3>

                    <p class="text-gray-400 text-sm max-w-md mx-auto mb-8">
                        Mulai tambahkan kosan pertama Anda untuk dikelola
                        dan ditampilkan kepada calon penyewa.
                    </p>

                    <a href="{{ route('pemilik.kosan.create') }}"
                       class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl text-sm font-semibold text-white shadow-lg hover:scale-[1.02] transition-all duration-200"
                       style="background: linear-gradient(135deg,#22c55e,#16a34a)">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 4v16m8-8H4"/>
                        </svg>

                        Tambah Kosan
                    </a>
                </div>
            @else

                {{-- Grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

                    @foreach($kosans as $kosan)

                        <div class="group bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">

                            {{-- Image --}}
                            <div class="relative overflow-hidden">

                                @if($kosan->fotoUtama)
                                    <img src="{{ asset('storage/' . $kosan->fotoUtama->foto) }}"
                                         alt="{{ $kosan->nama_kosan }}"
                                         class="w-full h-52 object-cover group-hover:scale-105 transition duration-500">
                                @endif

                                {{-- Status Badge --}}
                                <div class="absolute top-4 left-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold backdrop-blur-md
                                        {{ $kosan->status === 'aktif'
                                            ? 'bg-green-500/90 text-white'
                                            : 'bg-gray-700/80 text-white' }}">
                                        {{ ucfirst($kosan->status) }}
                                    </span>
                                </div>

                            </div>

                            {{-- Content --}}
                            <div class="p-5">

                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <h3 class="font-bold text-lg text-gray-800 line-clamp-1">
                                            {{ $kosan->nama_kosan }}
                                        </h3>

                                        <div class="flex items-center gap-1 text-gray-400 text-sm mt-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            </svg>

                                            {{ $kosan->kota }}
                                        </div>
                                    </div>

                                    <span class="text-xs px-3 py-1 rounded-full bg-gray-100 text-gray-500 capitalize">
                                        {{ $kosan->tipe }}
                                    </span>
                                </div>

                                {{-- Price --}}
                                <div class="mt-5">
                                    <p class="text-2xl font-bold text-green-600">
                                        Rp {{ number_format($kosan->harga_per_bulan, 0, ',', '.') }}
                                    </p>

                                    <p class="text-sm text-gray-400">
                                        per bulan
                                    </p>
                                </div>

                                {{-- Room --}}
                                <div class="mt-4 flex items-center justify-between bg-gray-50 rounded-2xl px-4 py-3">
                                    <div>
                                        <p class="text-xs text-gray-400">
                                            Kamar tersedia
                                        </p>

                                        <p class="font-semibold text-gray-700">
                                            {{ $kosan->kamar_tersedia }}/{{ $kosan->jumlah_kamar }}
                                        </p>
                                    </div>

                                    <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center">
                                        🛏️
                                    </div>
                                </div>

                                {{-- Actions --}}
                                <div class="grid grid-cols-3 gap-2 mt-5">

                                    <a href="{{ route('pemilik.kosan.show', $kosan) }}"
                                       class="text-center py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold transition">
                                        Detail
                                    </a>

                                    <a href="{{ route('pemilik.kosan.edit', $kosan) }}"
                                       class="text-center py-2.5 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-600 text-sm font-semibold transition">
                                        Edit
                                    </a>

                                    <form action="{{ route('pemilik.kosan.destroy', $kosan) }}"
                                          method="POST"
                                          onsubmit="return confirm('Hapus kosan ini?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="w-full py-2.5 rounded-xl bg-red-50 hover:bg-red-100 text-red-500 text-sm font-semibold transition">
                                            Hapus
                                        </button>
                                    </form>

                                </div>

                            </div>
                        </div>

                    @endforeach

                </div>

            @endif

        </div>
    </div>
</x-app-layout>