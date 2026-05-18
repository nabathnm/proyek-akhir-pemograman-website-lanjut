<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EasyKos — Selamat Datang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50 font-sans antialiased">
    <div class="min-h-screen flex flex-col items-center justify-center px-4 py-12">
        <div class="text-center mb-10">
            <div class="text-5xl mb-3">🏠</div>
            <h1 class="text-3xl font-extrabold text-gray-900">EasyKos</h1>
            <p class="text-gray-500 mt-2">Platform manajemen & pencarian kosan</p>
        </div>

        <div class="w-full max-w-md space-y-4">
            <a href="{{ route('home') }}"
               class="block w-full text-center px-6 py-4 rounded-2xl bg-white border border-gray-200 shadow-sm hover:shadow-md transition font-semibold text-gray-800">
                🔍 Cari Kosan (Tanpa Login)
            </a>

            <a href="{{ route('login') }}"
               class="block w-full text-center px-6 py-4 rounded-2xl text-white font-semibold shadow-md hover:shadow-lg transition"
               style="background:linear-gradient(135deg,#16a34a,#15803d)">
                Masuk ke Akun
            </a>

            <div class="grid grid-cols-2 gap-3">
                <a href="{{ route('register', ['role' => 'user']) }}"
                   class="text-center px-4 py-3 rounded-xl bg-blue-50 text-blue-700 font-semibold text-sm hover:bg-blue-100 transition">
                    Daftar sebagai Pencari Kos
                </a>
                <a href="{{ route('register', ['role' => 'pemilik']) }}"
                   class="text-center px-4 py-3 rounded-xl bg-green-50 text-green-700 font-semibold text-sm hover:bg-green-100 transition">
                    Daftar sebagai Pemilik
                </a>
            </div>
        </div>
    </div>
</body>
</html>
