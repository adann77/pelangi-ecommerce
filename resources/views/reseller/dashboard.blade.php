<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Reseller | Pelangi Accessories</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased">

    <nav class="bg-white border-b border-gray-100 shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-20">
            <a href="{{ route('home') }}" class="text-xl font-bold flex items-center gap-2">
                <span class="text-gray-900">Pelangi</span> <span class="text-pink-500">Accessories</span>
            </a>
            <div class="flex items-center gap-4">
                <span class="text-sm text-violet-600 font-medium">Halo, {{ auth()->user()->nama }}!</span>
                <span class="px-3 py-1 bg-violet-100 text-violet-700 text-xs font-bold rounded-full uppercase">Reseller</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-gray-400 hover:text-red-500 text-sm font-medium transition-colors">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Dashboard Reseller</h1>
        <p class="text-gray-500 mb-8">Selamat datang di panel reseller Pelangi Accessories</p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <div class="w-12 h-12 bg-violet-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path></svg>
                </div>
                <h3 class="font-bold text-gray-800">Diskon 10%</h3>
                <p class="text-sm text-gray-500 mt-1">Berlaku untuk semua produk</p>
            </div>
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <div class="w-12 h-12 bg-pink-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <h3 class="font-bold text-gray-800">Belanja Produk</h3>
                <p class="text-sm text-gray-500 mt-1"><a href="{{ route('katalog') }}" class="text-violet-600 hover:underline">Lihat katalog →</a></p>
            </div>
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <h3 class="font-bold text-gray-800">Materi Promosi</h3>
                <p class="text-sm text-gray-500 mt-1">Segera hadir</p>
            </div>
        </div>
    </div>

</body>
</html>