<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 text-sm text-gray-500">
            <a href="{{ route('kosan.show', $kosan) }}" class="hover:text-green-600 transition">{{ $kosan->nama_kosan }}</a>
            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-gray-800 font-semibold">Ajukan Pemesanan</span>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Flash Error --}}
            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('user.pemesanan.store') }}" class="space-y-6" x-data="{
                harga: {{ $kosan->harga_per_bulan }},
                durasi: {{ old('durasi_bulan', 1) }},
                get totalHarga() { return this.harga * this.durasi; }
            }">
                @csrf
                <input type="hidden" name="kosan_id" value="{{ $kosan->id }}">

                {{-- Card: Info Kosan --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-semibold text-gray-800 text-base mb-4 pb-3 border-b border-gray-100">🏠 Kosan yang Dipilih</h3>
                    <div class="flex gap-4">
                        @if($kosan->fotoUtama)
                            <img src="{{ asset('storage/' . $kosan->fotoUtama->foto) }}" alt="{{ $kosan->nama_kosan }}"
                                 class="w-28 h-20 object-cover rounded-xl border border-gray-100 shrink-0">
                        @else
                            <div class="w-28 h-20 bg-gray-100 rounded-xl flex items-center justify-center text-gray-300 shrink-0">
                                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                        <div class="min-w-0">
                            <h4 class="font-bold text-gray-900 truncate">{{ $kosan->nama_kosan }}</h4>
                            <p class="text-xs text-gray-500 flex items-center gap-1 mt-0.5">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $kosan->alamat }}, {{ $kosan->kota }}
                            </p>
                            <p class="text-sm font-bold text-green-700 mt-1">Rp {{ number_format($kosan->harga_per_bulan, 0, ',', '.') }} <span class="text-xs font-normal text-gray-400">/ bulan</span></p>
                            <p class="text-xs text-gray-400 mt-0.5">Pemilik: {{ $kosan->pemilik->name ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Card: Detail Pemesanan --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-semibold text-gray-800 text-base mb-4 pb-3 border-b border-gray-100">📋 Detail Pemesanan</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Masuk <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_masuk" value="{{ old('tanggal_masuk', date('Y-m-d')) }}"
                                   min="{{ date('Y-m-d') }}"
                                   class="w-full px-4 py-2.5 rounded-lg border {{ $errors->has('tanggal_masuk') ? 'border-red-400 bg-red-50' : 'border-gray-200' }} text-sm focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent">
                            @error('tanggal_masuk')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Durasi Sewa (Bulan) <span class="text-red-500">*</span></label>
                            <select name="durasi_bulan" x-model.number="durasi"
                                    class="w-full px-4 py-2.5 rounded-lg border {{ $errors->has('durasi_bulan') ? 'border-red-400 bg-red-50' : 'border-gray-200' }} text-sm focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent bg-white">
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" @selected(old('durasi_bulan', 1) == $i)>{{ $i }} Bulan</option>
                                @endfor
                            </select>
                            @error('durasi_bulan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Catatan <span class="text-gray-400 font-normal">(Opsional)</span></label>
                            <textarea name="catatan" rows="3" placeholder="Misalnya: waktu kedatangan, pertanyaan khusus, dll."
                                      class="w-full px-4 py-2.5 rounded-lg border {{ $errors->has('catatan') ? 'border-red-400 bg-red-50' : 'border-gray-200' }} text-sm focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent resize-none">{{ old('catatan') }}</textarea>
                            @error('catatan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                {{-- Card: Ringkasan Biaya --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-semibold text-gray-800 text-base mb-4 pb-3 border-b border-gray-100">💰 Ringkasan Biaya</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Harga per bulan</span>
                            <span class="font-semibold text-gray-800">Rp {{ number_format($kosan->harga_per_bulan, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Durasi sewa</span>
                            <span class="font-semibold text-gray-800" x-text="durasi + ' bulan'"></span>
                        </div>
                        <div class="border-t border-gray-100 pt-3 flex justify-between">
                            <span class="text-sm font-bold text-gray-800">Total Biaya</span>
                            <span class="text-lg font-extrabold text-green-700" x-text="'Rp ' + totalHarga.toLocaleString('id-ID')"></span>
                        </div>
                    </div>
                </div>

                {{-- Submit --}}
                <div class="flex gap-3">
                    <a href="{{ route('kosan.show', $kosan) }}"
                       class="flex-1 text-center py-3 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 text-sm font-semibold transition">Batal</a>
                    <button type="submit"
                            class="flex-1 py-3 rounded-xl text-white font-bold text-sm transition shadow-sm hover:shadow-md flex items-center justify-center gap-2"
                            style="background: linear-gradient(135deg, #16a34a, #15803d);">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Ajukan Pemesanan
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
