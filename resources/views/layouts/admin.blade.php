<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('pageTitle', 'Pelangi Accessories Admin')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <link href="https://api.fontshare.com/v2/css?f[]=plus-jakarta-sans@400,500,600,700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: {
                        gray: {
                            50: '#F9FAFB', 100: '#F3F4F6', 200: '#E5E7EB', 300: '#D1D5DB',
                            400: '#9CA3AF', 500: '#6B7280', 600: '#4B5563', 700: '#374151',
                            800: '#1F2937', 900: '#111827', 950: '#030712',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #E5E7EB; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #D1D5DB; }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.625rem 1rem;
            border-radius: 0.75rem;
            font-size: 0.8125rem;
            font-weight: 500;
            color: #6B7280;
            transition: all 150ms ease;
        }
        .nav-item:hover {
            background: #F9FAFB;
            color: #111827;
        }
        .nav-item.active {
            background: #111827;
            color: #FFFFFF;
        }
        .nav-item.active iconify-icon {
            color: #FFFFFF;
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="min-h-screen bg-gray-50 flex font-sans text-gray-900 selection:bg-gray-900 selection:text-white">

        <!-- ===================== SIDEBAR ===================== -->
        <aside class="w-[260px] bg-white border-r border-gray-200 flex flex-col fixed h-full z-20">

            <!-- Logo -->
            <div class="h-20 flex items-center px-6 border-b border-gray-100">
                <div>
                    <h1 class="font-bold text-gray-900 tracking-tight leading-tight">Pelangi Accessories</h1>
                    <div class="flex items-center gap-1.5 mt-0.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Admin Portal</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-4 py-6 overflow-y-auto">
                <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-widest mb-3 px-2">Menu Utama Admin</p>

                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="nav-item @yield('nav-dashboard', '')">
                            <iconify-icon icon="lucide:layout-dashboard" class="text-lg"></iconify-icon>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.produk.index') }}" class="nav-item @yield('nav-produk', '')">
                            <iconify-icon icon="lucide:package" class="text-lg"></iconify-icon>
                            Produk
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.kategori.index') }}" class="nav-item @yield('nav-kategori', '')">
                            <iconify-icon icon="lucide:tags" class="text-lg"></iconify-icon>
                            Kategori
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.pesanan.index') }}" class="nav-item @yield('nav-pesanan', '')">
                            <iconify-icon icon="lucide:shopping-cart" class="text-lg"></iconify-icon>
                            Pesanan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.pengiriman.index') }}" class="nav-item @yield('nav-pengiriman', '')">
                            <iconify-icon icon="lucide:truck" class="text-lg"></iconify-icon>
                            Pengiriman
                        </a>
                    </li>
                </ul>

                <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-widest mt-6 mb-3 px-2">Manajemen</p>

                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('admin.retur.index') }}" class="nav-item @yield('nav-retur', '')">
                            <iconify-icon icon="lucide:undo-2" class="text-lg"></iconify-icon>
                            Retur
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.rating.index') }}" class="nav-item @yield('nav-rating', '')">
                            <iconify-icon icon="lucide:star" class="text-lg"></iconify-icon>
                            Rating
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.reseller.index') }}" class="nav-item @yield('nav-reseller', '')">
                            <iconify-icon icon="lucide:users" class="text-lg"></iconify-icon>
                            Reseller
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.users.index') }}" class="nav-item @yield('nav-users', '')">
                            <iconify-icon icon="lucide:user-circle" class="text-lg"></iconify-icon>
                            Users
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.laporan') }}" class="nav-item @yield('nav-laporan', '')">
                            <iconify-icon icon="lucide:bar-chart-3" class="text-lg"></iconify-icon>
                            Laporan
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- User Section -->
            <div class="px-4 py-4 border-t border-gray-100">
                <div class="flex items-center gap-3 px-2">
                    <div class="w-9 h-9 rounded-full bg-gray-900 flex items-center justify-center text-white text-sm font-bold">
                        {{ strtoupper(auth()->user()->name ? auth()->user()->name[0] : 'A') }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-400 truncate">{{ auth()->user()->email }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="p-1.5 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-700 transition-colors" title="Logout">
                            <iconify-icon icon="lucide:log-out" class="text-lg"></iconify-icon>
                        </button>
                    </form>
                </div>
            </div>

        </aside>
        <!-- ===================== END SIDEBAR ===================== -->

        <!-- ===================== MAIN CONTENT ===================== -->
        <main class="ml-[260px] flex-1 flex flex-col">

            <!-- Top Header -->
            <header class="h-20 px-8 flex items-center justify-between bg-gray-50/80 backdrop-blur-md sticky top-0 z-10 border-b border-gray-200/50">
                <h2 class="text-2xl font-bold text-gray-900 tracking-tight">@yield('headerTitle', 'Dashboard')</h2>

                <div class="flex items-center gap-4">
                    @yield('headerActions', '')

                    <!-- Default: Search -->
                    <!-- <div class="relative hidden md:block">
                        <iconify-icon icon="lucide:search" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></iconify-icon>
                        <input type="text" placeholder="Cari transaksi, produk..."
                            class="pl-9 pr-4 py-2 w-64 rounded-full border border-gray-200 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition-shadow">
                    </div> -->
                </div>
            </header>

            <!-- Page Content -->
            <div class="p-8 max-w-7xl mx-auto w-full">
                @yield('content')
            </div>

        </main>
        <!-- ===================== END MAIN CONTENT ===================== -->

    </div>

    @stack('scripts')
</body>
</html>