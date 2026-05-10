@extends('layouts.admin')

@section('pageTitle', 'Dashboard — Pelangi Accessories Admin')

@section('nav-dashboard', 'active')

@section('headerTitle', 'Dashboard Admin')

@section('headerActions')
    
@endsection

@section('content')
<button class="flex items-center gap-2 px-4 py-2 rounded-full border border-gray-200 bg-white hover:bg-gray-50 text-sm font-medium text-gray-700 transition-colors shadow-sm">
        <iconify-icon icon="lucide:download" class="text-[16px]"></iconify-icon>
        Unduh Laporan
    </button>
    <!-- ===== METRICS GRID ===== -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">

        <!-- Card 1: Total Penjualan -->
        <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-[0_1px_2px_rgba(0,0,0,0.02)] relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-24 h-24 bg-gradient-to-bl from-gray-50 to-transparent rounded-bl-full -z-0 opacity-50 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-sm font-medium text-gray-500">Total Penjualan</h3>
                    <div class="w-8 h-8 rounded-full bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-600">
                        <iconify-icon icon="lucide:wallet" class="text-lg"></iconify-icon>
                    </div>
                </div>
                <div class="flex items-baseline gap-2 mb-1">
                    <span class="text-3xl font-bold text-gray-900 tracking-tight">Rp 12.5M</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded-md text-xs font-medium bg-emerald-50 text-emerald-700">
                        <iconify-icon icon="lucide:trending-up" class="text-[10px]"></iconify-icon>
                        +10%
                    </span>
                    <span class="text-xs text-gray-400">dari bulan lalu</span>
                </div>
            </div>
        </div>

        <!-- Card 2: Pesanan Baru -->
        <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-[0_1px_2px_rgba(0,0,0,0.02)] relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-24 h-24 bg-gradient-to-bl from-gray-50 to-transparent rounded-bl-full -z-0 opacity-50 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-sm font-medium text-gray-500">Pesanan Baru</h3>
                    <div class="w-8 h-8 rounded-full bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-600">
                        <iconify-icon icon="lucide:shopping-bag" class="text-lg"></iconify-icon>
                    </div>
                </div>
                <div class="flex items-baseline gap-2 mb-1">
                    <span class="text-3xl font-bold text-gray-900 tracking-tight">25</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded-md text-xs font-medium bg-emerald-50 text-emerald-700">
                        <iconify-icon icon="lucide:trending-up" class="text-[10px]"></iconify-icon>
                        +5%
                    </span>
                    <span class="text-xs text-gray-400">hari ini</span>
                </div>
            </div>
        </div>

        <!-- Card 3: Stok Menipis -->
        <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-[0_1px_2px_rgba(0,0,0,0.02)] relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-24 h-24 bg-gradient-to-bl from-rose-50/50 to-transparent rounded-bl-full -z-0 opacity-50 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-sm font-medium text-gray-500">Stok Menipis</h3>
                    <div class="w-8 h-8 rounded-full bg-rose-50 border border-rose-100 flex items-center justify-center text-rose-600">
                        <iconify-icon icon="lucide:alert-circle" class="text-lg"></iconify-icon>
                    </div>
                </div>
                <div class="flex items-baseline gap-2 mb-1">
                    <span class="text-3xl font-bold text-gray-900 tracking-tight">10</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded-md text-xs font-medium bg-rose-50 text-rose-700">
                        <iconify-icon icon="lucide:trending-down" class="text-[10px]"></iconify-icon>
                        -2%
                    </span>
                    <span class="text-xs text-gray-400">butuh perhatian</span>
                </div>
            </div>
        </div>

        <!-- Card 4: Pengguna Aktif -->
        <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-[0_1px_2px_rgba(0,0,0,0.02)] relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-24 h-24 bg-gradient-to-bl from-gray-50 to-transparent rounded-bl-full -z-0 opacity-50 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-sm font-medium text-gray-500">Pengguna Aktif</h3>
                    <div class="w-8 h-8 rounded-full bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-600">
                        <iconify-icon icon="lucide:activity" class="text-lg"></iconify-icon>
                    </div>
                </div>
                <div class="flex items-baseline gap-2 mb-1">
                    <span class="text-3xl font-bold text-gray-900 tracking-tight">150</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded-md text-xs font-medium bg-emerald-50 text-emerald-700">
                        <iconify-icon icon="lucide:trending-up" class="text-[10px]"></iconify-icon>
                        +8%
                    </span>
                    <span class="text-xs text-gray-400">minggu ini</span>
                </div>
            </div>
        </div>

    </div>
    <!-- ===== END METRICS GRID ===== -->

    <!-- ===== CHART SECTION ===== -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-[0_1px_2px_rgba(0,0,0,0.02)] p-6 md:p-8">

        <!-- Chart Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
            <div>
                <h2 class="text-base font-semibold text-gray-900 mb-1">Grafik Penjualan Bulanan</h2>
                <div class="flex items-center gap-3">
                    <span class="text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight">Rp 12.500.000</span>
                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-md text-xs font-medium bg-emerald-50 text-emerald-700">
                        Bulan ini +10%
                    </span>
                </div>
            </div>
            <div class="flex items-center p-1 bg-gray-50 rounded-lg border border-gray-200/60">
                <button class="px-3 py-1.5 text-xs font-medium rounded-md bg-white text-gray-900 shadow-sm border border-gray-200/50">Bulanan</button>
                <button class="px-3 py-1.5 text-xs font-medium rounded-md text-gray-500 hover:text-gray-900">Tahunan</button>
            </div>
        </div>

        <!-- Chart Area -->
        <div class="relative h-[300px] w-full">

            <!-- Y-Axis Grid Lines -->
            <div class="absolute inset-0 flex flex-col justify-between pointer-events-none pb-8">
                <div class="border-t border-gray-100 border-dashed w-full flex-1 flex items-start">
                    <span class="text-[10px] text-gray-400 -translate-y-2.5 -translate-x-8 absolute">20M</span>
                </div>
                <div class="border-t border-gray-100 border-dashed w-full flex-1 flex items-start">
                    <span class="text-[10px] text-gray-400 -translate-y-2.5 -translate-x-8 absolute">15M</span>
                </div>
                <div class="border-t border-gray-100 border-dashed w-full flex-1 flex items-start">
                    <span class="text-[10px] text-gray-400 -translate-y-2.5 -translate-x-8 absolute">10M</span>
                </div>
                <div class="border-t border-gray-100 border-dashed w-full flex-1 flex items-start">
                    <span class="text-[10px] text-gray-400 -translate-y-2.5 -translate-x-8 absolute">5M</span>
                </div>
                <div class="border-t border-gray-200 w-full mt-auto"></div>
            </div>

            <!-- SVG Chart -->
            <svg class="absolute inset-0 h-full w-full" preserveAspectRatio="none" viewBox="0 0 1000 300">
                <defs>
                    <linearGradient id="gradientFill" x1="0" y1="0" x2="0" y2="1">
                        <stop offset="0%" stop-color="#111827" stop-opacity="0.1" />
                        <stop offset="100%" stop-color="#111827" stop-opacity="0" />
                    </linearGradient>
                </defs>
                <path d="M 0 250 C 100 250, 120 120, 166 120 C 220 120, 280 180, 333 180 C 400 180, 450 90, 500 90 C 560 90, 600 150, 666 150 C 750 150, 780 40, 833 40 C 900 40, 950 100, 1000 100 L 1000 300 L 0 300 Z" fill="url(#gradientFill)" />
                <path d="M 0 250 C 100 250, 120 120, 166 120 C 220 120, 280 180, 333 180 C 400 180, 450 90, 500 90 C 560 90, 600 150, 666 150 C 750 150, 780 40, 833 40 C 900 40, 950 100, 1000 100" fill="none" stroke="#111827" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                <circle cx="166" cy="120" r="4" fill="#fff" stroke="#111827" stroke-width="2" />
                <circle cx="333" cy="180" r="4" fill="#fff" stroke="#111827" stroke-width="2" />
                <circle cx="500" cy="90" r="4" fill="#fff" stroke="#111827" stroke-width="2" />
                <circle cx="666" cy="150" r="4" fill="#fff" stroke="#111827" stroke-width="2" />
                <circle cx="833" cy="40" r="4" fill="#fff" stroke="#111827" stroke-width="2" />
                <circle cx="1000" cy="100" r="4" fill="#fff" stroke="#111827" stroke-width="2" />
            </svg>

            <!-- X-Axis Labels -->
            <div class="absolute bottom-0 left-0 w-full flex justify-between text-[11px] font-medium text-gray-500 pt-3 px-2">
                <span>Jan</span>
                <span class="ml-8">Feb</span>
                <span class="ml-8">Mar</span>
                <span class="ml-8">Apr</span>
                <span class="ml-8">Mei</span>
                <span class="ml-8">Jun</span>
                <span>Jul</span>
            </div>

            <!-- Static Tooltip -->
            <div class="absolute top-[10px] right-[140px] bg-gray-900 text-white text-xs px-3 py-2 rounded-lg shadow-xl border border-gray-800 pointer-events-none transform -translate-x-1/2 flex flex-col gap-1 z-10">
                <span class="font-medium">Juni 2024</span>
                <span class="font-bold">Rp 4.250.000</span>
                <div class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-2 h-2 bg-gray-900 rotate-45 border-r border-b border-gray-800"></div>
            </div>

        </div>

    </div>
    <!-- ===== END CHART SECTION ===== -->

@endsection