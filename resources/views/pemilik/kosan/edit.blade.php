<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('pemilik.kosan.index') }}" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h2 class="font-bold text-xl text-gray-800">Edit Kosan: {{ $kosan->nama_kosan }}</h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('pemilik.kosan.update', $kosan) }}" enctype="multipart/form-data"
                class="space-y-6">
                @csrf @method('PUT')

                {{-- Card: Informasi Dasar --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-semibold text-gray-800 text-base mb-4 pb-3 border-b border-gray-100">📋 Informasi
                        Kosan</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Kosan <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="nama_kosan" value="{{ old('nama_kosan', $kosan->nama_kosan) }}"
                                class="w-full px-4 py-2.5 rounded-lg border {{ $errors->has('nama_kosan') ? 'border-red-400 bg-red-50' : 'border-gray-200' }} text-sm focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent">
                            @error('nama_kosan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi <span
                                    class="text-red-500">*</span></label>
                            <textarea name="deskripsi" rows="4"
                                class="w-full px-4 py-2.5 rounded-lg border {{ $errors->has('deskripsi') ? 'border-red-400 bg-red-50' : 'border-gray-200' }} text-sm focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent resize-none">{{ old('deskripsi', $kosan->deskripsi) }}</textarea>
                            @error('deskripsi')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="alamat" value="{{ old('alamat', $kosan->alamat) }}"
                                    class="w-full px-4 py-2.5 rounded-lg border {{ $errors->has('alamat') ? 'border-red-400 bg-red-50' : 'border-gray-200' }} text-sm focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent">
                                @error('alamat')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Kota <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="kota" value="{{ old('kota', $kosan->kota) }}"
                                    class="w-full px-4 py-2.5 rounded-lg border {{ $errors->has('kota') ? 'border-red-400 bg-red-50' : 'border-gray-200' }} text-sm focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent">
                                @error('kota')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card: Detail & Harga --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-semibold text-gray-800 text-base mb-4 pb-3 border-b border-gray-100">💰 Detail &
                        Harga</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Harga per Bulan (Rp) <span
                                    class="text-red-500">*</span></label>
                            <input type="number" name="harga_per_bulan"
                                value="{{ old('harga_per_bulan', $kosan->harga_per_bulan) }}"
                                class="w-full px-4 py-2.5 rounded-lg border {{ $errors->has('harga_per_bulan') ? 'border-red-400 bg-red-50' : 'border-gray-200' }} text-sm focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent">
                            @error('harga_per_bulan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Tipe Kosan <span
                                    class="text-red-500">*</span></label>
                            <select name="tipe"
                                class="w-full px-4 py-2.5 rounded-lg border {{ $errors->has('tipe') ? 'border-red-400 bg-red-50' : 'border-gray-200' }} text-sm focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent bg-white">
                                <option value="putra" @selected(old('tipe', $kosan->tipe) === 'putra')>Putra</option>
                                <option value="putri" @selected(old('tipe', $kosan->tipe) === 'putri')>Putri</option>
                                <option value="campur" @selected(old('tipe', $kosan->tipe) === 'campur')>Campur</option>
                            </select>
                            @error('tipe')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Jumlah Kamar <span
                                    class="text-red-500">*</span></label>
                            <input type="number" name="jumlah_kamar"
                                value="{{ old('jumlah_kamar', $kosan->jumlah_kamar) }}" min="1"
                                class="w-full px-4 py-2.5 rounded-lg border {{ $errors->has('jumlah_kamar') ? 'border-red-400 bg-red-50' : 'border-gray-200' }} text-sm focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent">
                            @error('jumlah_kamar')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Kamar Tersedia <span
                                    class="text-red-500">*</span></label>
                            <input type="number" name="kamar_tersedia"
                                value="{{ old('kamar_tersedia', $kosan->kamar_tersedia) }}" min="0"
                                class="w-full px-4 py-2.5 rounded-lg border {{ $errors->has('kamar_tersedia') ? 'border-red-400 bg-red-50' : 'border-gray-200' }} text-sm focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent">
                            @error('kamar_tersedia')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
                            <select name="status"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-400 bg-white">
                                <option value="aktif" @selected(old('status', $kosan->status) === 'aktif')>Aktif</option>
                                <option value="nonaktif" @selected(old('status', $kosan->status) === 'nonaktif')>Nonaktif
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Card: Fasilitas --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-semibold text-gray-800 text-base mb-4 pb-3 border-b border-gray-100">✅ Fasilitas
                    </h3>
                    @php
                        $fasilitasList = ['WiFi', 'AC', 'Kamar Mandi Dalam', 'Kamar Mandi Luar', 'Dapur', 'Parkir Motor', 'Parkir Mobil', 'Lemari', 'Kasur', 'Meja Belajar', 'TV', 'Laundry'];
                        $currentFasilitas = old('fasilitas', $kosan->fasilitas ?? []);
                    @endphp
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        @foreach($fasilitasList as $fasilitas)
                            <label class="flex items-center gap-2 cursor-pointer group">
                                <input type="checkbox" name="fasilitas[]" value="{{ $fasilitas }}"
                                    @checked(in_array($fasilitas, $currentFasilitas))
                                    class="w-4 h-4 rounded border-gray-300 text-green-600 focus:ring-green-400 cursor-pointer">
                                <span
                                    class="text-sm text-gray-700 group-hover:text-green-700 transition">{{ $fasilitas }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- Card: Foto Existing --}}
                @if($kosan->fotos->count())
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="font-semibold text-gray-800 text-base mb-4 pb-3 border-b border-gray-100">🖼️ Foto Saat
                            Ini</h3>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                            @foreach($kosan->fotos as $foto)
                                <div
                                    class="relative rounded-xl border {{ $foto->is_utama ? 'border-green-500 ring-2 ring-green-200' : 'border-gray-200' }} overflow-hidden flex flex-col group">
                                    <div class="relative h-24 sm:h-32">
                                        <img src="{{ asset('storage/' . $foto->foto) }}" class="w-full h-full object-cover">
                                        @if($foto->is_utama)
                                            <span
                                                class="absolute top-2 left-2 bg-green-600 text-white text-xs px-2 py-1 rounded-md font-semibold shadow-sm">Utama</span>
                                        @endif
                                    </div>
                                    <div class="p-3 bg-gray-50 flex flex-col gap-2.5 border-t border-gray-100">
                                        <label
                                            class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer hover:text-green-700 transition-colors">
                                            <input type="radio" name="foto_utama_id" value="{{ $foto->id }}" {{ $foto->is_utama ? 'checked' : '' }}
                                                class="w-4 h-4 text-green-600 focus:ring-green-500 cursor-pointer">
                                            <span class="{{ $foto->is_utama ? 'font-semibold text-green-700' : '' }}">Jadikan
                                                Utama</span>
                                        </label>
                                        <label
                                            class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer hover:text-red-600 transition-colors">
                                            <input type="checkbox" name="hapus_fotos[]" value="{{ $foto->id }}"
                                                class="w-4 h-4 rounded text-red-600 focus:ring-red-500 cursor-pointer border-gray-300">
                                            <span class="text-red-600 font-medium">Hapus Foto</span>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <p class="text-xs text-gray-500 mt-4"><span class="font-semibold text-gray-700">Info:</span> Anda
                            bisa memilih satu foto sebagai foto utama (ditampilkan paling depan) dan menghapus foto yang
                            tidak diinginkan.</p>
                    </div>
                @endif

                {{-- Card: Upload Foto Baru --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-semibold text-gray-800 text-base mb-1 pb-3 border-b border-gray-100">📷 Tambah Foto
                        Baru</h3>
                    <p class="text-xs text-gray-400 mt-3 mb-4">Opsional. Format: JPG, PNG, GIF. Maks 10MB/foto.</p>

                    <label for="fotos"
                        class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-200 rounded-xl cursor-pointer hover:border-green-400 hover:bg-green-50 transition-all">
                        <svg class="w-7 h-7 text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="text-sm text-gray-400">Klik untuk pilih foto baru</p>
                        <p id="file-count" class="text-xs text-green-600 mt-1 hidden"></p>
                        <input type="file" id="fotos" name="fotos[]" multiple accept="image/*" class="hidden"
                            onchange="previewFotos(this)">
                    </label>
                    <div id="foto-preview" class="grid grid-cols-3 sm:grid-cols-4 gap-3 mt-4 hidden"></div>
                </div>

                {{-- Submit --}}
                <div class="flex gap-3">
                    <a href="{{ route('pemilik.kosan.index') }}"
                        class="flex-1 text-center py-3 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 text-sm font-semibold transition">Batal</a>
                    <button type="submit"
                        class="flex-1 py-3 rounded-xl text-white font-bold text-sm transition shadow-sm hover:shadow-md"
                        style="background: linear-gradient(135deg, #16a34a, #15803d);">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewFotos(input) {
            const preview = document.getElementById('foto-preview');
            const counter = document.getElementById('file-count');
            preview.innerHTML = '';
            if (input.files && input.files.length > 0) {
                preview.classList.remove('hidden');
                counter.classList.remove('hidden');
                counter.textContent = input.files.length + ' foto dipilih';
                Array.from(input.files).forEach(function (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const div = document.createElement('div');
                        div.innerHTML = `<img src="${e.target.result}" class="w-full h-24 object-cover rounded-lg border border-gray-100">`;
                        preview.appendChild(div);
                    };
                    reader.readAsDataURL(file);
                });
            } else {
                preview.classList.add('hidden');
                counter.classList.add('hidden');
            }
        }
    </script>
</x-app-layout>