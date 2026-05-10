@extends('layouts.admin')

@section('pageTitle', 'Laporan Penjualan — Pelangi Accessories Admin')

@section('nav-laporan', 'active')

@section('headerTitle', 'Laporan Penjualan')

@section('headerActions')
   
@endsection

@section('content')
 <button class="flex items-center gap-2 px-4 py-2.5 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-sm font-medium text-gray-700 transition-colors shadow-sm">
        <iconify-icon icon="lucide:printer" class="text-base"></iconify-icon>
        Cetak
    </button>
    <button class="flex items-center gap-2 px-4 py-2.5 rounded-xl bg-gray-900 text-white text-sm font-medium hover:bg-gray-800 transition-all shadow-sm active:scale-[0.98]">
        <iconify-icon icon="lucide:download" class="text-base"></iconify-icon>
        Export PDF
    </button>
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">

        <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-[0_1px_2px_rgba(0,0,0,0.02)] relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-20 h-20 bg-gradient-to-bl from-emerald-50 to-transparent rounded-bl-full -z-0 opacity-60 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-3">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Pendapatan</h3>
                    <div class="w-8 h-8 rounded-full bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600">
                        <iconify-icon icon="lucide:wallet" class="text-base"></iconify-icon>
                    </div>
                </div>
                <div class="flex items-baseline gap-1 mb-1">
                    <span class="text-sm text-gray-500">Rp</span>
                    <span class="text-2xl font-bold text-gray-900 tracking-tight">{{ number_format($totalPendapatan, 0, ',', '.') }}</span>
                </div>
                <div class="flex items-center gap-1.5 mt-1">
                    <span class="text-xs text-gray-400">Dari Pesanan Selesai</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-[0_1px_2px_rgba(0,0,0,0.02)] relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-20 h-20 bg-gradient-to-bl from-blue-50 to-transparent rounded-bl-full -z-0 opacity-60 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-3">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Transaksi</h3>
                    <div class="w-8 h-8 rounded-full bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600">
                        <iconify-icon icon="lucide:receipt" class="text-base"></iconify-icon>
                    </div>
                </div>
                <div class="flex items-baseline gap-2 mb-1">
                    <span class="text-3xl font-bold text-gray-900 tracking-tight">{{ $totalTransaksi }}</span>
                </div>
                <div class="flex items-center gap-1.5 mt-1">
                    <span class="text-xs text-gray-400">Semua pesanan</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-[0_1px_2px_rgba(0,0,0,0.02)] relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-20 h-20 bg-gradient-to-bl from-amber-50 to-transparent rounded-bl-full -z-0 opacity-60 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-3">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Produk Terlaris</h3>
                    <div class="w-8 h-8 rounded-full bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-600">
                        <iconify-icon icon="lucide:flame" class="text-base"></iconify-icon>
                    </div>
                </div>
                <div class="flex items-baseline gap-2 mb-1">
                    <span class="text-lg font-bold text-gray-900 tracking-tight leading-tight">{{ $produkTerlaris ? $produkTerlaris->nama_produk : 'Belum Ada' }}</span>
                </div>
                <div class="flex items-center gap-1.5 mt-1">
                    <span class="text-xs text-gray-400">Berdasarkan stok terendah</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-[0_1px_2px_rgba(0,0,0,0.02)] relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-20 h-20 bg-gradient-to-bl from-purple-50 to-transparent rounded-bl-full -z-0 opacity-60 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-3">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Pelanggan Aktif</h3>
                    <div class="w-8 h-8 rounded-full bg-purple-50 border border-purple-100 flex items-center justify-center text-purple-600">
                        <iconify-icon icon="lucide:users" class="text-base"></iconify-icon>
                    </div>
                </div>
                <div class="flex items-baseline gap-2 mb-1">
                    <span class="text-3xl font-bold text-gray-900 tracking-tight">{{ $pelangganAktif }}</span>
                </div>
                <div class="flex items-center gap-1.5 mt-1">
                    <span class="text-xs text-gray-400">Total member aktif</span>
                </div>
            </div>
        </div>

    </div>
    <div class="bg-white rounded-2xl border border-gray-200 shadow-[0_1px_2px_rgba(0,0,0,0.02)] flex-1 flex flex-col overflow-hidden">

        <form action="{{ route('admin.laporan') }}" method="GET" class="p-4 border-b border-gray-100">
            <div class="flex flex-col sm:flex-row gap-3">
                <div class="relative flex-1">
                    <iconify-icon icon="lucide:search" class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-base"></iconify-icon>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari ID transaksi, nama pelanggan..." class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent placeholder:text-gray-400 text-gray-900">
                </div>
                <div class="flex items-center gap-2">
                    <div class="relative">
                        <input type="date" name="start_date" value="{{ request('start_date') }}" class="appearance-none bg-gray-50 border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent cursor-pointer">
                    </div>
                    <span class="text-gray-400 text-sm">—</span>
                    <div class="relative">
                        <input type="date" name="end_date" value="{{ request('end_date') }}" class="appearance-none bg-gray-50 border border-gray-200 rounded-xl px-3 py-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent cursor-pointer">
                    </div>
                </div>
                <button type="submit" class="flex items-center justify-center gap-2 px-5 py-2.5 bg-gray-900 hover:bg-gray-800 text-white text-sm font-medium rounded-xl transition-colors shadow-sm active:scale-[0.98] whitespace-nowrap">
                    <iconify-icon icon="lucide:search" class="text-base"></iconify-icon>
                    Cari
                </button>
            </div>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/80 border-b border-gray-200">
                        <th class="px-5 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Tanggal</th>
                        <th class="px-5 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">ID Transaksi</th>
                        <th class="px-5 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Pelanggan</th>
                        <th class="px-5 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Kurir</th>
                        <th class="px-5 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Status</th>
                        <th class="px-5 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap text-right">Total Harga</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    
                    @forelse($pesanan as $p)
                        @php
                            $namaUser = $p->user->nama ?? 'Guest';
                            $initials = collect(explode(' ', $namaUser))->take(2)->map(fn($w) => strtoupper(substr($w, 0, 1)))->join('');
                            $colors = ['purple', 'blue', 'emerald', 'rose', 'amber', 'indigo', 'cyan'];
                            $color = $colors[($p->id_user ?? 0) % count($colors)];
                        @endphp
                        <tr class="hover:bg-gray-50/60 transition-colors">
                            <td class="px-5 py-4"><span class="text-sm text-gray-500 whitespace-nowrap">{{ $p->tanggal_pesanan->format('d M Y') }}</span></td>
                            <td class="px-5 py-4"><span class="text-sm font-semibold text-gray-900 whitespace-nowrap">#TRX-{{ str_pad($p->id_pesanan, 3, '0', STR_PAD_LEFT) }}</span></td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-full bg-{{ $color }}-50 flex items-center justify-center border border-{{ $color }}-100 shrink-0 text-[10px] font-bold text-{{ $color }}-600">{{ $initials }}</div>
                                    <span class="text-sm text-gray-700 whitespace-nowrap">{{ $namaUser }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <span class="text-sm font-medium text-gray-700">{{ $p->layanan_kurir ?? '-' }}</span>
                            </td>
                            <td class="px-5 py-4">
                                @if($p->status_pesanan === 'selesai')
                                    <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-md text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-100/50">Selesai</span>
                                @elseif($p->status_pesanan === 'dibatalkan')
                                    <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-md text-xs font-medium bg-rose-50 text-rose-700 border border-rose-100/50">Dibatalkan</span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-md text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100/50">{{ ucfirst($p->status_pesanan) }}</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-right"><span class="text-sm text-gray-900 font-semibold whitespace-nowrap">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-sm text-gray-500">Belum ada data transaksi.</td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        <div class="px-5 py-4 border-t border-gray-200 bg-gray-50/50 flex flex-col sm:flex-row items-center justify-between gap-4 mt-auto">
            <span class="text-sm text-gray-500">
                Menampilkan <span class="font-medium text-gray-900">{{ $pesanan->firstItem() ?? 0 }}-{{ $pesanan->lastItem() ?? 0 }}</span> 
                dari <span class="font-medium text-gray-900">{{ $pesanan->total() }}</span> transaksi
            </span>
            <div class="flex items-center gap-1.5">
                {{ $pesanan->links('pagination::tailwind') }}
            </div>
        </div>
    </div>

@endsection