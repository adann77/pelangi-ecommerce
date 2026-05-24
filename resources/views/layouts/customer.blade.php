<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('pageTitle', 'Pelangi Accessories')</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Iconify CDN -->
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    
    <style>
        /* Smooth scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
    </style>
</head>
<body class="bg-gray-50 font-sans text-gray-800">

    <div class="flex min-h-screen">
        
        <!-- ===== SIDEBAR ===== -->
        <aside class="w-64 bg-violet-50 border-r border-violet-100 flex flex-col p-6 fixed h-full overflow-y-auto z-40">
            
            <!-- Nama Pengguna (Menggantikan Logo Bulat) -->
            <div class="mb-10 px-2">
                <h2 class="text-2xl font-bold text-violet-800">Reseller</h2>
                <p class="text-sm text-violet-500 mt-1 truncate">{{ auth()->user()->name ?? auth()->user()->nama ?? 'User' }}</p>
            </div>

            <!-- Menu Navigasi Sidebar -->
            <nav class="flex-1 space-y-2">
                <!-- Dashboard (Aktif) -->
                <a href="/dashboard" class="flex items-center gap-3 px-4 py-2.5 bg-violet-600 text-white rounded-lg font-medium shadow-sm transition-all">
                    <iconify-icon icon="lucide:layout-dashboard" class="text-xl"></iconify-icon>
                    Dashboard
                </a>

                <!-- Pesanan Saya -->
                <a href="/pesanan" class="flex items-center gap-3 px-4 py-2.5 text-gray-700 hover:bg-violet-100 rounded-lg transition-colors">
                    <iconify-icon icon="lucide:shopping-bag" class="text-xl text-violet-500"></iconify-icon>
                    Pesanan Saya
                </a>

                <!-- Return Produk -->
                <a href="/return" class="flex items-center gap-3 px-4 py-2.5 text-gray-700 hover:bg-violet-100 rounded-lg transition-colors">
                    <iconify-icon icon="lucide:package-plus" class="text-xl text-violet-500"></iconify-icon>
                    Return Produk
                </a>

                <!-- Rating Produk -->
                <a href="/rating" class="flex items-center gap-3 px-4 py-2.5 text-gray-700 hover:bg-violet-100 rounded-lg transition-colors">
                    <iconify-icon icon="lucide:star" class="text-xl text-violet-500"></iconify-icon>
                    Rating Produk
                </a>

            <!-- Ajukan Reseller -->
            <!-- <a href="{{ route('reseller.register.form') }}" class="flex items-center gap-3 px-4 py-2.5 text-gray-700 hover:bg-violet-100 rounded-lg transition-colors">
                <iconify-icon icon="lucide:user-plus" class="text-xl text-violet-500"></iconify-icon>
                Ajukan Reseller
            </a> -->

            <!-- Logout -->
            <div class="mt-auto pt-6 border-t border-violet-200">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 w-full px-4 py-2.5 text-red-500 hover:bg-red-50 rounded-lg transition-colors font-medium">
                        <iconify-icon icon="lucide:log-out" class="text-xl"></iconify-icon>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- ===== MAIN CONTENT ===== -->
        <main class="flex-1 ml-64 flex flex-col min-h-screen bg-gray-50">
            
            <!-- ===== TOP NAVBAR (Sesuai Desain Referensi) ===== -->
            <header class="sticky top-0 z-30 bg-white border-b border-gray-200 px-8 py-4 flex items-center justify-between">
                
                <!-- Kiri: Logo -->
                <div class="flex-shrink-0">
                    <a href="/" class="text-2xl font-extrabold text-violet-700 hover:text-violet-800 transition-colors">
                        Pelangi Accessories
                    </a>
                </div>

                <!-- Tengah: Menu Navigasi -->
                <nav class="hidden md:flex items-center gap-8">
                    <a href="/" class="text-gray-600 hover:text-violet-600 font-medium transition-colors text-sm">Beranda</a>
                    <a href="/katalog" class="text-gray-600 hover:text-violet-600 font-medium transition-colors text-sm">Katalog</a>
                    <a href="/about" class="text-gray-600 hover:text-violet-600 font-medium transition-colors text-sm">Tentang Kami</a>
                    
                </nav>

                <!-- Kanan: Search, Cart, Notif -->
                <div class="flex items-center gap-5">
                    <!-- Search Bar -->
                    <div class="hidden lg:flex items-center bg-gray-100 rounded-full px-4 py-2 w-64">
                        <iconify-icon icon="lucide:search" class="text-gray-400 text-lg mr-2"></iconify-icon>
                        <input type="text" placeholder="Cari aksesoris..." class="bg-transparent outline-none text-sm text-gray-700 w-full placeholder-gray-400">
                    </div>
                    
                    <!-- Cart Icon -->
                    <a href="/cart" class="text-gray-500 hover:text-violet-600 transition-colors relative">
                        <iconify-icon icon="lucide:shopping-cart" class="text-2xl"></iconify-icon>
                    </a>

                    <!-- Bell Icon -->
                    <a href="#" class="text-gray-500 hover:text-violet-600 transition-colors relative">
                        <iconify-icon icon="lucide:bell" class="text-2xl"></iconify-icon>
                    </a>
                </div>
            </header>

            <!-- Page Content (Dari View Dashboard) -->
            <div class="flex-1 p-8">
                @yield('content')
            </div>

        </main>

    </div>

</body>
</html>