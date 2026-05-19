<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800">Profil Saya</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
                    @csrf
                    @method('patch')

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama</label>
                        <input type="text" name="nama" value="{{ old('nama', $user->nama) }}" required
                               class="w-full px-4 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                        @error('nama')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                               class="w-full px-4 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                        @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <p class="text-sm text-gray-500">
                        Role: <span class="font-semibold capitalize">{{ $user->role === 'pemilik' ? 'Pemilik Kos' : 'Pencari Kos' }}</span>
                    </p>

                    @if(session('status') === 'profile-updated')
                        <p class="text-green-600 text-sm">Profil berhasil diperbarui.</p>
                    @endif

                    <button type="submit"
                            class="px-6 py-2.5 rounded-lg text-white text-sm font-semibold"
                            style="background:linear-gradient(135deg,#16a34a,#15803d)">
                        Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
