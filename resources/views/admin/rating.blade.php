@extends('layouts.admin')

@section('pageTitle', 'Kelola Rating — Pelangi Accessories Admin')
@section('nav-rating', 'active')
@section('headerTitle', 'Kelola Rating')

@section('content')

    <!-- ===== TOP STATS ===== -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <!-- Store Rating -->
        <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-[0_1px_2px_rgba(0,0,0,0.02)] relative overflow-hidden group">
            <!-- dekorasi tetap sama... -->
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-3">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Rating Toko</h3>
                    <div class="w-8 h-8 rounded-full bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-600">
                        <iconify-icon icon="lucide:star" class="text-base"></iconify-icon>
                    </div>
                </div>
                <div class="flex items-baseline gap-2 mb-1">
                    <span class="text-3xl font-bold text-gray-900 tracking-tight">{{ number_format($avgRating, 1) }}</span>
                    <span class="text-sm text-gray-400 font-medium">/ 5.0</span>
                </div>
            </div>
        </div>

        <!-- Total Reviews -->
        <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-[0_1px_2px_rgba(0,0,0,0.02)] relative overflow-hidden group">
            <!-- dekorasi tetap sama... -->
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-3">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Ulasan</h3>
                    <div class="w-8 h-8 rounded-full bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600">
                        <iconify-icon icon="lucide:message-square" class="text-base"></iconify-icon>
                    </div>
                </div>
                <div class="flex items-baseline gap-2 mb-1">
                    <span class="text-3xl font-bold text-gray-900 tracking-tight">{{ $totalReviews }}</span>
                    <span class="text-sm text-gray-400 font-medium">ulasan</span>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== FILTER PENCARIAN ===== -->
    <form action="{{ route('admin.rating.index') }}" method="GET" class="bg-white rounded-2xl border border-gray-200 shadow-[0_1px_2px_rgba(0,0,0,0.02)] p-5 mb-6">
        <h3 class="text-sm font-semibold text-gray-900 mb-4">Filter Pencarian</h3>
        <div class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <iconify-icon icon="lucide:search" class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-base"></iconify-icon>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama produk..." class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent placeholder:text-gray-400 text-gray-900">
            </div>
            <div class="relative">
                <select name="bintang" class="appearance-none bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 pr-10 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent cursor-pointer min-w-[180px]">
                    <option value="">Semua Bintang</option>
                    <option value="5" {{ request('bintang') == '5' ? 'selected' : '' }}>⭐ 5 Bintang</option>
                    <option value="4" {{ request('bintang') == '4' ? 'selected' : '' }}>⭐ 4 Bintang</option>
                    <option value="3" {{ request('bintang') == '3' ? 'selected' : '' }}>⭐ 3 Bintang</option>
                    <option value="2" {{ request('bintang') == '2' ? 'selected' : '' }}>⭐ 2 Bintang</option>
                    <option value="1" {{ request('bintang') == '1' ? 'selected' : '' }}>⭐ 1 Bintang</option>
                </select>
                <iconify-icon icon="lucide:chevron-down" class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none"></iconify-icon>
            </div>
            <button type="submit" class="flex items-center justify-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-xl transition-colors shadow-sm active:scale-[0.98] whitespace-nowrap">
                <iconify-icon icon="lucide:filter" class="text-base"></iconify-icon>
                Terapkan Filter
            </button>
        </div>
    </form>

    <!-- Data Table -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-[0_1px_2px_rgba(0,0,0,0.02)] flex-1 flex flex-col overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/80 border-b border-gray-200">
                        <th class="px-5 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">ID Rating</th>
                        <th class="px-5 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Customer</th>
                        <th class="px-5 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Produk</th>
                        <th class="px-5 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Rating</th>
                        <th class="px-5 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Komentar</th>
                        <th class="px-5 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Tanggal</th>
                        <th class="px-5 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Status</th>
                        <th class="px-5 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    
                    @forelse ($ratings as $item)
                    @php 
                        // Inisial nama
                        $nameParts = explode(' ', $item->user->nama);
                        $initials = strtoupper(substr($nameParts[0], 0, 1)) . (isset($nameParts[1]) ? strtoupper(substr($nameParts[1], 0, 1)) : '');
                    @endphp

                    <tr class="hover:bg-gray-50/60 transition-colors group">
                        <td class="px-5 py-4"><span class="text-sm font-semibold text-gray-900 whitespace-nowrap">#RTG-{{ str_pad($item->id_rating, 3, '0', STR_PAD_LEFT) }}</span></td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center border border-blue-100 shrink-0 text-xs font-bold text-blue-600">{{ $initials }}</div>
                                <span class="text-sm font-medium text-gray-900 whitespace-nowrap">{{ $item->user->nama }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-md bg-gray-50 flex items-center justify-center border border-gray-200 shrink-0">
                                    <iconify-icon icon="lucide:gem" class="text-gray-400 text-xs"></iconify-icon>
                                </div>
                                <span class="text-sm text-gray-700 whitespace-nowrap">{{ $item->produk->nama_produk }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-0.5">
                                @for ($i = 1; $i <= 5; $i++)
                                    <iconify-icon icon="lucide:star" class="text-sm {{ $i <= $item->rating ? 'text-amber-400' : 'text-gray-300' }}" style="{{ $i <= $item->rating ? '--iconify-stroke:0;fill:currentColor' : '' }}"></iconify-icon>
                                @endfor
                            </div>
                        </td>
                        <td class="px-5 py-4"><span class="text-sm text-gray-600 line-clamp-1 max-w-[200px]">{{ $item->komentar ?? '-' }}</span></td>
                        <td class="px-5 py-4"><span class="text-sm text-gray-500 whitespace-nowrap">{{ $item->created_at->format('d M Y') }}</span></td>
                        <td class="px-5 py-4">
                            @if($item->status === 'aktif')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100/50 whitespace-nowrap">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600 border border-gray-200/50 whitespace-nowrap">
                                <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Disembunyikan
                            </span>
                            @endif
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                
                                @if($item->status === 'aktif')
                                <form action="{{ route('admin.rating.toggleStatus', $item->id_rating) }}" method="POST">
                                    @csrf @method('PUT')
                                    <button type="submit" class="p-2 text-gray-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors" title="Sembunyikan">
                                        <iconify-icon icon="lucide:eye-off" class="text-[16px]"></iconify-icon>
                                    </button>
                                </form>
                                @else
                                <form action="{{ route('admin.rating.toggleStatus', $item->id_rating) }}" method="POST">
                                    @csrf @method('PUT')
                                    <button type="submit" class="p-2 text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors" title="Tampilkan">
                                        <iconify-icon icon="lucide:eye" class="text-[16px]"></iconify-icon>
                                    </button>
                                </form>
                                @endif

                                <form action="{{ route('admin.rating.destroy', $item->id_rating) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus rating ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-gray-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors" title="Hapus">
                                        <iconify-icon icon="lucide:trash-2" class="text-[16px]"></iconify-icon>
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-10 text-gray-500">Belum ada data rating.</td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        <!-- Pagination Footer -->
        <div class="px-5 py-4 border-t border-gray-200 bg-gray-50/50 flex flex-col sm:flex-row items-center justify-between gap-4 mt-auto">
            <span class="text-sm text-gray-500">
                Menampilkan <span class="font-medium text-gray-900">{{ $ratings->firstItem() ?? 0 }}-{{ $ratings->lastItem() ?? 0 }}</span> 
                dari <span class="font-medium text-gray-900">{{ $ratings->total() }}</span> ulasan
            </span>
            <div class="flex items-center gap-1.5">
                {{ $ratings->links() }}
            </div>
        </div>
    </div>

@endsection