<x-app-layout>
    <x-slot name="header">
        <p class="nb-kicker">Daftar</p>
        <h2 class="text-4xl font-black leading-none">Beranda Kosan</h2>
    </x-slot>

    <div class="pt-6">
        <div class="nb-shell">
            <form method="GET" action="{{ route('kosan.search') }}" class="nb-card p-4 md:p-5">
                <div class="grid gap-3 md:grid-cols-[1fr_auto]">
                    <label for="q" class="sr-only">Cari kosan, kota</label>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari kosan, kota..."
                           id="q" class="nb-input" />
                    <button type="submit" class="nb-btn nb-btn-primary">Cari</button>
                </div>
            </form>

            <div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @forelse($kosans as $kosan)
                    <a href="{{ route('kosan.show', $kosan) }}"
                        class="nb-card nb-card-hover overflow-hidden">
                        @if($kosan->fotoUtama)
                            <img src="{{ asset('storage/' . $kosan->fotoUtama->foto) }}" alt="{{ $kosan->nama_kosan }}"
                                 class="h-48 w-full object-cover">
                        @else
                            <div class="flex h-48 items-center justify-center bg-[#E5E7EB] text-xl font-bold">
                                Tidak Ada Foto
                            </div>
                        @endif

                        <div class="p-4">
                            <div class="mb-2 flex items-center justify-between gap-2">
                                <span
                                    class="nb-kicker border-2 border-black px-2 py-1 {{ $kosan->tipe === 'putra' ? 'bg-blue-200' : ($kosan->tipe === 'putri' ? 'bg-pink-200' : 'bg-yellow-200') }}">
                                    {{ ucfirst($kosan->tipe) }}
                                </span>
                                <span class="nb-kicker">{{ $kosan->kamar_tersedia }} kamar</span>
                            </div>
                            <h3 class="text-3xl font-black leading-none">{{ $kosan->nama_kosan }}</h3>
                            <p class="mt-2 text-lg font-medium">
                                {{ $kosan->kota }}
                            </p>
                            <p class="mt-2 text-2xl font-black">
                                Rp {{ number_format($kosan->harga_per_bulan, 0, ',', '.') }}
                                <span class="nb-kicker">/bulan</span>
                            </p>
                        </div>
                    </a>
                @empty
                    <div class="nb-card col-span-full p-10 text-center">
                        <p class="nb-kicker">Kosong</p>
                        <p class="mt-2 text-4xl font-black">Belum Ada Kosan Tersedia</p>
                        <p class="mt-2 text-xl font-medium">Coba ubah kata kunci pencarian.</p>
                    </div>
                @endforelse
            </div>

            @if($kosans->hasPages())
                <div class="mt-8">{{ $kosans->links() }}</div>
            @endif
        </div>
    </div>
</x-app-layout>
