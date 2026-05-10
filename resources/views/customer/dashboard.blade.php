@extends('layouts.customer')

@section('pageTitle', 'Dashboard — Pelangi Accessories')

@section('nav-dashboard', 'active')

@section('content')

    @php
        // Ambil nama user (cek kemungkinan kolom 'name' atau 'nama')
        $userName = auth()->user()->name ?? auth()->user()->nama ?? 'Pelanggan';
        $userEmail = auth()->user()->email ?? '-';
        $userAddress = auth()->user()->address ?? auth()->user()->alamat ?? 'Belum diatur';
        $userPhone = auth()->user()->phone ?? auth()->user()->telepon ?? auth()->user()->no_hp ?? 'Belum diatur';
        $userInitial = strtoupper(substr($userName, 0, 1));

        $orderStats = [
            ['label' => 'Total Pesanan', 'value' => 4, 'icon' => 'lucide:shopping-bag', 'color' => 'violet', 'trend' => '+1', 'trend_label' => 'bulan ini'],
            ['label' => 'Diproses', 'value' => 2, 'icon' => 'lucide:loader', 'color' => 'amber', 'trend' => '+1', 'trend_label' => 'sedang diproses'],
            ['label' => 'Dikirim', 'value' => 1, 'icon' => 'lucide:truck', 'color' => 'sky', 'trend' => '0', 'trend_label' => 'dalam perjalanan'],
            ['label' => 'Selesai', 'value' => 10, 'icon' => 'lucide:check-circle', 'color' => 'emerald', 'trend' => '+3', 'trend_label' => 'bulan ini'],
        ];

        $latestOrders = [
            ['product' => 'Tas Ransel', 'price' => 'Rp 150.000', 'status' => 'Diproses', 'status_color' => 'amber', 'date' => '28 Des 2025', 'image' => asset('storage/image/cat_tas_1777044293009.png'), 'order_id' => 'PLG-20251228-001'],
            ['product' => 'Kalung Mutiara Pink', 'price' => 'Rp 150.000', 'status' => 'Dikirim', 'status_color' => 'sky', 'date' => '25 Des 2025', 'image' => asset('storage/image/cat_kalung_1777044262810.png'), 'order_id' => 'PLG-20251225-003'],
            ['product' => 'Kacamata Hitam Elegan', 'price' => 'Rp 95.000', 'status' => 'Selesai', 'status_color' => 'emerald', 'date' => '20 Des 2025', 'image' => asset('storage/image/cat_kacamata_1777044307764.png'), 'order_id' => 'PLG-20251220-007'],
        ];

        $recommendations = [
            ['name' => 'Anting Mutiara Elegan', 'price' => 'Rp 85.000', 'image' => 'https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?w=300&q=80', 'rating' => 4.8],
            ['name' => 'Jam Tangan Rose Gold', 'price' => 'Rp 275.000', 'image' => 'https://images.unsplash.com/photo-1524592094714-0f0654e20314?w=300&q=80', 'rating' => 4.9],
            ['name' => 'Gelang Charm Pastel', 'price' => 'Rp 65.000', 'image' => 'https://images.unsplash.com/photo-1573408301185-9146fe634ad0?w=300&q=80', 'rating' => 4.7],
            ['name' => 'Cincin Minimalis Silver', 'price' => 'Rp 55.000', 'image' => 'https://images.unsplash.com/photo-1605100804763-247f67b3557e?w=300&q=80', 'rating' => 4.6],
        ];
    @endphp

    <!-- ===== GREETING BANNER (Tanpa Bulat Putih) ===== -->
    <div class="bg-gradient-to-r from-violet-600 via-violet-500 to-pink-400 rounded-2xl p-6 md:p-8 mb-8 relative overflow-hidden shadow-lg">
        <div class="absolute -top-16 -right-16 w-48 h-48 bg-white/10 rounded-full blur-2xl"></div>
        <div class="absolute -bottom-16 -left-16 w-48 h-48 bg-pink-300/20 rounded-full blur-2xl"></div>
        <div class="absolute top-4 right-6 opacity-10">
            <iconify-icon icon="lucide:sparkles" class="text-[80px] text-white"></iconify-icon>
        </div>
        <div class="relative z-10">
            <p class="text-white/80 text-sm font-medium mb-1">Selamat datang,</p>
            <h2 class="text-2xl md:text-3xl font-bold text-white mb-1">{{ $userName }} 👋</h2>
            <p class="text-white/80 text-sm md:text-base">Senang melihatmu kembali. Yuk, cek perkembangan pesananmu!</p>
        </div>
    </div>

    <!-- ===== INFORMASI AKUN ===== -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-[0_1px_2px_rgba(0,0,0,0.02)] p-6 mb-8 relative overflow-hidden group">
        <div class="absolute right-0 top-0 w-24 h-24 bg-gradient-to-bl from-violet-50/50 to-transparent rounded-bl-full -z-0 opacity-50 transition-transform group-hover:scale-110"></div>
        <div class="relative z-10">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-base font-semibold text-gray-900">Informasi Akun</h3>
                <a href="#" class="text-violet-600 text-sm font-medium hover:text-pink-400 transition-colors flex items-center gap-1">
                    <iconify-icon icon="lucide:pencil" class="text-[14px]"></iconify-icon>
                    Edit
                </a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-violet-50 rounded-lg flex items-center justify-center flex-shrink-0">
                        <iconify-icon icon="lucide:user" class="text-lg text-violet-600"></iconify-icon>
                    </div>
                    <div>
                        <p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Nama Lengkap</p>
                        <p class="text-gray-800 font-medium text-sm mt-0.5">{{ $userName }}</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-violet-50 rounded-lg flex items-center justify-center flex-shrink-0">
                        <iconify-icon icon="lucide:map-pin" class="text-lg text-violet-600"></iconify-icon>
                    </div>
                    <div>
                        <p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Alamat</p>
                        <p class="text-gray-800 font-medium text-sm mt-0.5">{{ $userAddress }}</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-violet-50 rounded-lg flex items-center justify-center flex-shrink-0">
                        <iconify-icon icon="lucide:mail" class="text-lg text-violet-600"></iconify-icon>
                    </div>
                    <div>
                        <p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">Email</p>
                        <p class="text-gray-800 font-medium text-sm mt-0.5">{{ $userEmail }}</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-violet-50 rounded-lg flex items-center justify-center flex-shrink-0">
                        <iconify-icon icon="lucide:phone" class="text-lg text-violet-600"></iconify-icon>
                    </div>
                    <div>
                        <p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider">No. Telepon</p>
                        <p class="text-gray-800 font-medium text-sm mt-0.5">{{ $userPhone }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== ORDER STATISTICS ===== -->
    <div class="grid grid-cols-2 xl:grid-cols-4 gap-4 md:gap-6 mb-8">
        @foreach($orderStats as $stat)
        @php
            $bgCorner = match($stat['color']) {
                'violet' => 'from-violet-50/50',
                'amber' => 'from-amber-50/50',
                'sky' => 'from-sky-50/50',
                'emerald' => 'from-emerald-50/50',
                default => 'from-gray-50/50',
            };
            $iconBg = match($stat['color']) {
                'violet' => 'bg-violet-50 border-violet-100 text-violet-600',
                'amber' => 'bg-amber-50 border-amber-100 text-amber-600',
                'sky' => 'bg-sky-50 border-sky-100 text-sky-600',
                'emerald' => 'bg-emerald-50 border-emerald-100 text-emerald-600',
                default => 'bg-gray-50 border-gray-100 text-gray-600',
            };
            $badgeBg = match($stat['color']) {
                'violet' => 'bg-violet-50 text-violet-700',
                'amber' => 'bg-amber-50 text-amber-700',
                'sky' => 'bg-sky-50 text-sky-700',
                'emerald' => 'bg-emerald-50 text-emerald-700',
                default => 'bg-gray-50 text-gray-700',
            };
        @endphp
        <div class="bg-white rounded-2xl p-5 md:p-6 border border-gray-200 shadow-[0_1px_2px_rgba(0,0,0,0.02)] relative overflow-hidden group hover:shadow-md transition-shadow">
            <div class="absolute right-0 top-0 w-24 h-24 bg-gradient-to-bl {{ $bgCorner }} to-transparent rounded-bl-full -z-0 opacity-50 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-xs md:text-sm font-medium text-gray-500">{{ $stat['label'] }}</h3>
                    <div class="w-8 h-8 rounded-full {{ $iconBg }} border flex items-center justify-center">
                        <iconify-icon icon="{{ $stat['icon'] }}" class="text-lg"></iconify-icon>
                    </div>
                </div>
                <div class="flex items-baseline gap-2 mb-1">
                    <span class="text-2xl md:text-3xl font-bold text-gray-900 tracking-tight">{{ $stat['value'] }}</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded-md text-[10px] md:text-xs font-medium {{ $badgeBg }}">
                        <iconify-icon icon="lucide:trending-up" class="text-[10px]"></iconify-icon>
                        {{ $stat['trend'] }}
                    </span>
                    <span class="text-[10px] md:text-xs text-gray-400">{{ $stat['trend_label'] }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- ===== MAIN GRID: Orders + Recommendations ===== -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 md:gap-8 mb-8">
        <!-- Latest Orders -->
        <div class="xl:col-span-2">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-base font-semibold text-gray-900">Pesanan Terbaru</h3>
                <a href="#" class="text-violet-600 text-sm font-medium hover:text-pink-400 transition-colors flex items-center gap-1">
                    Lihat Semua <iconify-icon icon="lucide:arrow-right" class="text-[14px]"></iconify-icon>
                </a>
            </div>
            <div class="space-y-4">
                @foreach($latestOrders as $order)
                @php
                    $statusBg = match($order['status_color']) {
                        'amber' => 'bg-amber-100 text-amber-700',
                        'sky' => 'bg-sky-100 text-sky-700',
                        'emerald' => 'bg-emerald-100 text-emerald-700',
                        default => 'bg-gray-100 text-gray-700',
                    };
                @endphp
                <div class="bg-white rounded-2xl border border-gray-200 shadow-[0_1px_2px_rgba(0,0,0,0.02)] p-4 md:p-5 hover:shadow-md transition-shadow flex flex-col sm:flex-row items-start sm:items-center gap-4">
                    <div class="w-16 h-16 md:w-20 md:h-20 rounded-xl overflow-hidden bg-gray-50 flex-shrink-0 border border-gray-100">
                        <img src="{{ $order['image'] }}" alt="{{ $order['product'] }}" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-1 min-w-0 w-full">
                        <div class="flex items-start justify-between gap-2">
                            <div>
                                <h4 class="font-semibold text-gray-800 text-sm md:text-base">{{ $order['product'] }}</h4>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $order['order_id'] }} · {{ $order['date'] }}</p>
                            </div>
                            <span class="text-sm md:text-base font-bold text-violet-600 whitespace-nowrap">{{ $order['price'] }}</span>
                        </div>
                        <div class="flex items-center justify-between mt-3">
                            <span class="px-3 py-1 {{ $statusBg }} text-xs font-semibold rounded-full">{{ $order['status'] }}</span>
                            <a href="#" class="text-violet-600 text-xs font-medium hover:text-pink-400 transition-colors flex items-center gap-1">
                                Detail Pesanan <iconify-icon icon="lucide:arrow-right" class="text-[12px]"></iconify-icon>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Recommendations -->
        <div>
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-base font-semibold text-gray-900">Rekomendasi</h3>
                <a href="/katalog" class="text-violet-600 text-sm font-medium hover:text-pink-400 transition-colors flex items-center gap-1">
                    Lihat Semua <iconify-icon icon="lucide:arrow-right" class="text-[14px]"></iconify-icon>
                </a>
            </div>
            <div class="space-y-3">
                @foreach($recommendations as $rec)
                <div class="bg-white rounded-2xl border border-gray-200 shadow-[0_1px_2px_rgba(0,0,0,0.02)] overflow-hidden hover:shadow-md transition-all cursor-pointer group">
                    <div class="flex items-center gap-3 p-3 md:p-4">
                        <div class="w-14 h-14 md:w-16 md:h-16 rounded-xl overflow-hidden bg-gray-50 flex-shrink-0 border border-gray-100">
                            <img src="{{ $rec['image'] }}" alt="{{ $rec['name'] }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                        </div>
                        <div class="min-w-0 flex-1">
                            <h4 class="font-medium text-gray-800 text-xs md:text-sm truncate">{{ $rec['name'] }}</h4>
                            <div class="flex items-center gap-1 mt-0.5">
                                <iconify-icon icon="lucide:star" class="text-yellow-400 text-[13px]"></iconify-icon>
                                <span class="text-xs text-gray-400">{{ $rec['rating'] }}</span>
                            </div>
                            <p class="text-sm font-bold text-violet-600 mt-1">{{ $rec['price'] }}</p>
                        </div>
                        <button class="w-8 h-8 rounded-full bg-violet-50 border border-violet-100 flex items-center justify-center text-violet-600 hover:bg-violet-600 hover:text-white hover:border-violet-600 transition-colors flex-shrink-0">
                            <iconify-icon icon="lucide:plus" class="text-[14px]"></iconify-icon>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- ===== CTA RESELLER ===== -->
    <div class="rounded-2xl bg-gradient-to-r from-pink-400 to-orange-300 p-6 md:p-10 shadow-lg relative overflow-hidden mb-4">
        <div class="absolute -top-24 -right-24 w-64 h-64 bg-white opacity-20 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-white opacity-20 rounded-full blur-3xl"></div>
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="text-center md:text-left md:w-2/3">
                <h2 class="text-2xl md:text-3xl font-bold text-white mb-3">Gabung Reseller Sekarang </h2>
                <p class="text-white/90 text-sm md:text-base max-w-xl">Dapatkan harga khusus, materi promosi eksklusif, dan mulai bangun bisnis aksesorismu sendiri bersama Pelangi Accessories.</p>
            </div>
            <div class="flex items-center gap-4 flex-shrink-0">
                <div class="bg-white rounded-xl p-4 md:p-5 text-center shadow-lg transform rotate-2 hover:rotate-0 hover:scale-105 transition-all duration-300">
                    <span class="block text-3xl md:text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-pink-400 to-orange-300 mb-1">200+</span>
                    <span class="text-gray-600 text-xs font-medium">Reseller Sukses</span>
                </div>
                <a href="{{ route('reseller.register.form') }}" class="bg-gray-900 text-white px-5 md:px-6 py-3 rounded-full font-semibold text-sm hover:bg-gray-800 hover:scale-105 hover:shadow-xl transition-all whitespace-nowrap flex items-center gap-2">
                <iconify-icon icon="lucide:rocket" class="text-[16px]"></iconify-icon>
                Daftar Sekarang
            </a>
            </div>
        </div>
    </div>

@endsection