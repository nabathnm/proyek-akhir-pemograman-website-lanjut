<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 text-sm text-gray-500">
            <a href="{{ route('home') }}" class="hover:text-green-600 transition">Beranda</a>
            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-gray-800 font-semibold">{{ $kosan->nama_kosan }}</span>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm flex items-center gap-2 shadow-sm">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm shadow-sm">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Galeri Foto --}}
            <div x-data="{ active: 0 }" class="mb-8">
                @if($kosan->fotos->count())
                    <div class="rounded-2xl overflow-hidden shadow-md border border-gray-100 bg-white">
                        <div class="relative">
                            @foreach($kosan->fotos as $i => $foto)
                                <img x-show="active === {{ $i }}" x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                    src="{{ asset('storage/' . $foto->foto) }}" alt="{{ $kosan->nama_kosan }}"
                                    class="w-full h-72 sm:h-96 object-cover">
                            @endforeach
                            @if($kosan->fotos->count() > 1)
                                <button @click="active = active > 0 ? active - 1 : {{ $kosan->fotos->count() - 1 }}"
                                    class="absolute left-3 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-white/80 backdrop-blur flex items-center justify-center shadow hover:bg-white transition">
                                    <svg class="w-4 h-4 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 19l-7-7 7-7" />
                                    </svg>
                                </button>
                                <button @click="active = active < {{ $kosan->fotos->count() - 1 }} ? active + 1 : 0"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-white/80 backdrop-blur flex items-center justify-center shadow hover:bg-white transition">
                                    <svg class="w-4 h-4 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                                <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-1.5">
                                    @foreach($kosan->fotos as $i => $foto)
                                        <button @click="active = {{ $i }}"
                                            :class="active === {{ $i }} ? 'bg-white w-6' : 'bg-white/50 w-2'"
                                            class="h-2 rounded-full transition-all duration-300"></button>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    <div
                        class="rounded-2xl bg-gray-50 border border-gray-200 h-64 flex flex-col items-center justify-center text-gray-300">
                        <svg class="w-12 h-12 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="text-sm">Belum ada foto</span>
                    </div>
                @endif
            </div>

            {{-- Content Grid --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Kiri: Info Detail --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Judul & Badge --}}
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                        <div class="flex flex-wrap items-center gap-2 mb-3">
                            <span
                                class="text-xs px-2 py-1 rounded-full font-semibold
                                {{ $kosan->tipe === 'putra' ? 'bg-blue-50 text-blue-600' : ($kosan->tipe === 'putri' ? 'bg-pink-50 text-pink-600' : 'bg-purple-50 text-purple-600') }}">
                                Kos {{ ucfirst($kosan->tipe) }}
                            </span>
                            <span
                                class="text-xs px-2 py-1 rounded-full font-semibold {{ $kosan->status === 'aktif' ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }}">
                                {{ ucfirst($kosan->status) }}
                            </span>
                        </div>
                        <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $kosan->nama_kosan }}</h1>
                        <p class="flex items-center gap-1 text-sm text-gray-500">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ $kosan->alamat }}, {{ $kosan->kota }}
                        </p>
                        <div class="flex items-center gap-3 mt-3">
                            <div class="flex items-center gap-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= round($ratingRata ?? 0) ? 'text-yellow-400' : 'text-gray-200' }}"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @endfor
                                <span
                                    class="text-sm font-semibold text-gray-700 ml-1">{{ number_format($ratingRata ?? 0, 1) }}</span>
                            </div>
                            <span class="text-xs text-gray-400">({{ $totalUlasan }} ulasan)</span>
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                        <h2 class="text-lg font-bold text-gray-800 mb-3">Deskripsi</h2>
                        <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-line">{{ $kosan->deskripsi }}</p>
                    </div>

                    {{-- Fasilitas --}}
                    @if($kosan->fasilitas && count($kosan->fasilitas))
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                            <h2 class="text-lg font-bold text-gray-800 mb-4">Fasilitas</h2>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                @foreach($kosan->fasilitas as $f)
                                    <div
                                        class="flex items-center gap-2 text-sm text-gray-700 bg-gray-50 rounded-xl px-3 py-2.5">
                                        <svg class="w-4 h-4 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        {{ ucfirst($f) }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Info Kamar --}}
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                        <h2 class="text-lg font-bold text-gray-800 mb-4">Informasi Kamar</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-gray-50 rounded-xl p-4 text-center">
                                <p class="text-2xl font-bold text-gray-800">{{ $kosan->jumlah_kamar }}</p>
                                <p class="text-xs text-gray-500 mt-1">Total Kamar</p>
                            </div>
                            <div class="bg-green-50 rounded-xl p-4 text-center">
                                <p class="text-2xl font-bold text-green-700">{{ $kosan->kamar_tersedia }}</p>
                                <p class="text-xs text-gray-500 mt-1">Kamar Tersedia</p>
                            </div>
                        </div>
                    </div>

                    {{-- Ulasan --}}
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                        <h2 class="text-lg font-bold text-gray-800 mb-4">Ulasan ({{ $totalUlasan }})</h2>

                        @if($kosan->ulasans->count())
                            <div class="space-y-4">
                                @foreach($kosan->ulasans->sortByDesc('created_at') as $ulasan)
                                    <div class="border-b border-gray-50 pb-4 last:border-0 last:pb-0">
                                        <div class="flex items-center gap-3 mb-2">
                                            <div
                                                class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-bold text-xs">
                                                {{ strtoupper(substr($ulasan->user->name ?? '?', 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-gray-800">
                                                    {{ $ulasan->user->name ?? 'Anonim' }}
                                                </p>
                                                <div class="flex items-center gap-0.5">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <svg class="w-3 h-3 {{ $i <= $ulasan->rating ? 'text-yellow-400' : 'text-gray-200' }}"
                                                            fill="currentColor" viewBox="0 0 20 20">
                                                            <path
                                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                        </svg>
                                                    @endfor
                                                </div>
                                            </div>
                                            <span
                                                class="text-xs text-gray-400 ml-auto">{{ $ulasan->created_at->diffForHumans() }}</span>
                                        </div>
                                        @if($ulasan->komentar)
                                            <p class="text-sm text-gray-600 ml-11">{{ $ulasan->komentar }}</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-gray-400 text-center py-4">Belum ada ulasan untuk kosan ini.</p>
                        @endif

                        {{-- Form Ulasan --}}
                        @auth
                            @if(Auth::user()->role === 'user')
                                @if($sudahUlasan)
                                    <p class="mt-4 text-xs text-gray-400 text-center">✅ Kamu sudah memberikan ulasan untuk kosan ini.</p>
                                @elseif($bisaUlas)
                                    <div class="mt-6 pt-5 border-t border-gray-100">
                                        <h3 class="text-sm font-semibold text-gray-700 mb-3">Tulis Ulasan</h3>
                                        <form action="{{ route('user.kosan.ulasan', $kosan) }}" method="POST" class="space-y-3">
                                            @csrf
                                            <div x-data="{ rating: 0, hover: 0 }">
                                                <label class="text-xs text-gray-500 mb-1 block">Rating</label>
                                                <div class="flex gap-1">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <button type="button" @click="rating = {{ $i }}" @mouseenter="hover = {{ $i }}"
                                                            @mouseleave="hover = 0"
                                                            class="focus:outline-none transition-transform hover:scale-110">
                                                            <svg class="w-6 h-6 transition-colors"
                                                                :class="(hover || rating) >= {{ $i }} ? 'text-yellow-400' : 'text-gray-200'"
                                                                fill="currentColor" viewBox="0 0 20 20">
                                                                <path
                                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                            </svg>
                                                        </button>
                                                    @endfor
                                                </div>
                                                <input type="hidden" name="rating" :value="rating">
                                            </div>
                                            <div>
                                                <label class="text-xs text-gray-500 mb-1 block">Komentar</label>
                                                <textarea name="komentar" rows="3" placeholder="Bagikan pengalamanmu..."
                                                    class="w-full rounded-xl border border-gray-200 text-sm px-4 py-2.5 focus:ring-2 focus:ring-green-400 focus:border-transparent resize-none"></textarea>
                                            </div>
                                            <button type="submit"
                                                class="px-5 py-2 text-sm font-semibold text-white rounded-xl transition hover:shadow-md"
                                                style="background:linear-gradient(135deg,#16a34a,#15803d)">
                                                Kirim Ulasan
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <div class="mt-6 pt-5 border-t border-gray-100">
                                        <p class="text-sm text-gray-500 text-center">🔒 Anda baru bisa memberikan ulasan setelah melakukan pemesanan dan disetujui oleh pemilik kosan.</p>
                                    </div>
                                @endif
                            @endif
                        @endauth
                    </div>
                </div>

                {{-- Kanan: Sidebar Harga & Booking --}}
                <div class="space-y-6">
                    {{-- Card Harga --}}
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                        <p class="text-2xl font-bold text-green-700">
                            Rp {{ number_format($kosan->harga_per_bulan, 0, ',', '.') }}
                            <span class="text-sm font-normal text-gray-400">/ bulan</span>
                        </p>

                        <div class="mt-4 space-y-2 text-sm text-gray-600">
                            <div class="flex justify-between py-2 border-b border-gray-50">
                                <span>Tipe</span>
                                <span class="font-semibold text-gray-800">{{ ucfirst($kosan->tipe) }}</span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-gray-50">
                                <span>Kamar Tersedia</span>
                                <span class="font-semibold text-gray-800">{{ $kosan->kamar_tersedia }}</span>
                            </div>
                            <div class="flex justify-between py-2">
                                <span>Pemilik</span>
                                <span class="font-semibold text-gray-800">{{ $kosan->pemilik->name ?? '-' }}</span>
                            </div>
                        </div>

                        @auth
                            @if(Auth::user()->role === 'user' && $kosan->kamar_tersedia > 0)
                                <a href="{{ route('user.pemesanan.create', ['kosan_id' => $kosan->id]) }}"
                                    class="mt-5 w-full inline-flex items-center justify-center gap-2 px-5 py-3 text-sm font-semibold text-white rounded-xl transition hover:shadow-lg"
                                    style="background:linear-gradient(135deg,#16a34a,#15803d)">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Ajukan Pemesanan
                                </a>
                            @elseif($kosan->kamar_tersedia <= 0)
                                <div
                                    class="mt-5 w-full text-center px-5 py-3 text-sm font-semibold text-red-500 bg-red-50 rounded-xl">
                                    Kamar Penuh
                                </div>
                            @endif
                        @else
                            <a href="{{ route('login') }}"
                                class="mt-5 w-full inline-flex items-center justify-center gap-2 px-5 py-3 text-sm font-semibold text-white rounded-xl transition hover:shadow-lg"
                                style="background:linear-gradient(135deg,#16a34a,#15803d)">
                                Masuk untuk Memesan
                            </a>
                        @endauth
                    </div>

                    {{-- Info Pemilik --}}
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                        <h3 class="text-sm font-bold text-gray-800 mb-3">Pemilik Kosan</h3>
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-bold text-sm">
                                {{ strtoupper(substr($kosan->pemilik->name ?? '?', 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">{{ $kosan->pemilik->name ?? '-' }}</p>
                                @if($kosan->pemilik->no_hp)
                                    <p class="text-xs text-gray-400">{{ $kosan->pemilik->no_hp }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>