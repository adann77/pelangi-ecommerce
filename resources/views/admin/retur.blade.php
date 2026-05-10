@extends('layouts.admin')

@section('pageTitle', 'Manajemen Retur — Pelangi Accessories Admin')

@section('nav-retur', 'active')

@section('headerTitle', 'Retur Produk')

@section('headerActions')
 
@endsection

@section('content')
   <a href="{{ route('admin.retur.export') }}" class="flex items-center gap-2 px-4 py-2.5 rounded-xl bg-gray-900 text-white text-sm font-medium hover:bg-gray-800 transition-all shadow-sm active:scale-[0.98]">
        <iconify-icon icon="lucide:download" class="text-lg"></iconify-icon>
        Export Data
    </a>
    <!-- ===== STATUS TABS ===== -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-[0_1px_2px_rgba(0,0,0,0.02)] p-1.5 mb-6">
        <div class="flex flex-wrap gap-1">
            @php
                $tabConfigs = [
                    ['key' => 'semua',    'label' => 'Semua',     'color' => 'gray'],
                    ['key' => 'menunggu', 'label' => 'Menunggu',  'color' => 'amber'],
                    ['key' => 'diproses', 'label' => 'Diproses',  'color' => 'blue'],
                    ['key' => 'selesai',  'label' => 'Selesai',   'color' => 'emerald'],
                    ['key' => 'ditolak',  'label' => 'Ditolak',   'color' => 'rose'],
                ];
            @endphp

            @foreach($tabConfigs as $tab)
                @php
                    $isActive = ($status === $tab['key']);
                    $countBg = $isActive
                        ? 'bg-white/20 text-white'
                        : ($tab['key'] === 'semua' ? 'bg-gray-900 text-white' : "bg-{$tab['color']}-50 text-{$tab['color']}-700");
                @endphp
                <a href="{{ route('admin.retur.index', array_filter(['status' => $tab['key'] !== 'semua' ? $tab['key'] : null, 'search' => $search])) }}"
                   class="retur-tab flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium transition-all
                          {{ $isActive ? 'bg-gray-900 text-white' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">
                    <span>{{ $tab['label'] }}</span>
                    <span class="tab-count {{ $countBg }} text-[10px] py-0.5 px-2 rounded-full font-bold">
                        {{ $counts[$tab['key']] }}
                    </span>
                </a>
            @endforeach
        </div>
    </div>
    <!-- ===== END STATUS TABS ===== -->

    <!-- Search Bar -->
    <form method="GET" action="{{ route('admin.retur.index') }}" class="bg-white p-2 rounded-2xl border border-gray-200 shadow-[0_1px_2px_rgba(0,0,0,0.02)] mb-6 flex flex-col sm:flex-row gap-2">
        @if($status !== 'semua')
            <input type="hidden" name="status" value="{{ $status }}">
        @endif
        <div class="relative flex-1">
            <iconify-icon icon="lucide:search" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-lg"></iconify-icon>
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari ID retur, nama pelanggan, atau produk..." class="w-full pl-11 pr-4 py-2.5 bg-transparent text-sm focus:outline-none placeholder:text-gray-400 text-gray-900">
        </div>
        <button type="submit" class="px-4 py-2.5 bg-gray-900 text-white text-sm font-medium rounded-xl hover:bg-gray-800 transition-all">
            Cari
        </button>
        @if($search)
            <a href="{{ route('admin.retur.index', array_filter(['status' => $status !== 'semua' ? $status : null])) }}" class="px-4 py-2.5 bg-gray-100 text-gray-600 text-sm font-medium rounded-xl hover:bg-gray-200 transition-all text-center">
                Reset
            </a>
        @endif
    </form>

    <!-- Data Table -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-[0_1px_2px_rgba(0,0,0,0.02)] flex-1 flex flex-col overflow-hidden mb-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/80 border-b border-gray-200">
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">ID</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Pelanggan</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Produk</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Alasan</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Tanggal</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Status</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">

                    @forelse($returs as $retur)
                        @php
                            $color = $retur->status_color;
                            $initials = $retur->initials;
                            $avatarColor = $retur->avatar_color;
                        @endphp

                        <tr class="hover:bg-gray-50/60 transition-colors group">
                            <td class="px-6 py-4">
                                <span class="text-sm font-semibold text-gray-900 whitespace-nowrap">{{ $retur->kode_return }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-{{ $avatarColor }}-50 flex items-center justify-center border border-{{ $avatarColor }}-100 shrink-0 text-xs font-bold text-{{ $avatarColor }}-600">
                                        {{ $initials }}
                                    </div>
                                    <span class="text-sm font-medium text-gray-900 whitespace-nowrap">{{ $retur->user->nama ?? 'User Dihapus' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-md bg-gray-50 flex items-center justify-center border border-gray-200 shrink-0">
                                        @if($retur->produk->gambar_produk)
                                            <img src="{{ asset('storage/' . $retur->produk->gambar_produk) }}" class="w-full h-full object-cover rounded-md" alt="">
                                        @else
                                            <iconify-icon icon="lucide:gem" class="text-gray-400 text-sm"></iconify-icon>
                                        @endif
                                    </div>
                                    <span class="text-sm text-gray-700 whitespace-nowrap">{{ $retur->produk->nama_produk ?? 'Produk Dihapus' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-600 whitespace-nowrap max-w-[180px] truncate block">{{ Str::limit($retur->alasan_return, 30) }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-500 whitespace-nowrap">{{ $retur->tanggal_pengajuan->format('d M Y') }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-{{ $color }}-50 text-{{ $color }}-700 border border-{{ $color }}-100/50 whitespace-nowrap">
                                    <span class="w-1.5 h-1.5 rounded-full bg-{{ $color }}-500"></span>
                                    {{ $retur->status_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                    @if($retur->status_return === 'pending')
                                        <button onclick="openApproveModal({{ $retur->id_return }}, '{{ $retur->kode_return }}')"
                                                class="p-2 text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors" title="Setujui">
                                            <iconify-icon icon="lucide:check" class="text-[16px]"></iconify-icon>
                                        </button>
                                        <button onclick="openRejectModal({{ $retur->id_return }}, '{{ $retur->kode_return }}')"
                                                class="p-2 text-gray-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors" title="Tolak">
                                            <iconify-icon icon="lucide:x" class="text-[16px]"></iconify-icon>
                                        </button>
                                    @elseif($retur->status_return === 'diproses')
                                        <button onclick="openCompleteModal({{ $retur->id_return }}, '{{ $retur->kode_return }}')"
                                                class="p-2 text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors" title="Selesaikan">
                                            <iconify-icon icon="lucide:check-circle" class="text-[16px]"></iconify-icon>
                                        </button>
                                    @endif
                                    <button onclick="openDetailModal({{ $retur->id_return }})"
                                            class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Detail">
                                        <iconify-icon icon="lucide:eye" class="text-[16px]"></iconify-icon>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-16 h-16 rounded-full bg-gray-50 flex items-center justify-center">
                                        <iconify-icon icon="lucide:package-x" class="text-gray-300 text-3xl"></iconify-icon>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Belum ada data retur</p>
                                        <p class="text-xs text-gray-500 mt-1">Data retur akan muncul di sini saat pelanggan mengajukan pengembalian.</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        <!-- Pagination Footer -->
        @if($returs->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50/50 flex flex-col sm:flex-row items-center justify-between gap-4 mt-auto">
                <span class="text-sm text-gray-500">
                    Menampilkan <span class="font-medium text-gray-900">{{ $returs->firstItem() }}</span>-<span class="font-medium text-gray-900">{{ $returs->lastItem() }}</span>
                    dari <span class="font-medium text-gray-900">{{ $returs->total() }}</span> retur
                </span>
                <div class="flex items-center gap-1.5">
                    @if($returs->onFirstPage())
                        <button class="p-1.5 rounded-lg border border-gray-200 bg-white text-gray-400 disabled:opacity-50 transition-colors" disabled>
                            <iconify-icon icon="lucide:chevron-left" class="text-[18px]"></iconify-icon>
                        </button>
                    @else
                        <a href="{{ $returs->previousPageUrl() }}" class="p-1.5 rounded-lg border border-gray-200 bg-white text-gray-700 hover:text-gray-900 hover:bg-gray-50 transition-colors inline-flex">
                            <iconify-icon icon="lucide:chevron-left" class="text-[18px]"></iconify-icon>
                        </a>
                    @endif

                    <div class="flex items-center px-2">
                        @foreach($returs->getUrlRange(max(1, $returs->currentPage() - 2), min($returs->lastPage(), $returs->currentPage() + 2)) as $page => $url)
                            @if($page == $returs->currentPage())
                                <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-gray-900 text-white text-sm font-medium">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-600 hover:bg-gray-100 text-sm font-medium transition-colors">{{ $page }}</a>
                            @endif
                        @endforeach
                    </div>

                    @if($returs->hasMorePages())
                        <a href="{{ $returs->nextPageUrl() }}" class="p-1.5 rounded-lg border border-gray-200 bg-white text-gray-700 hover:text-gray-900 hover:bg-gray-50 transition-colors inline-flex">
                            <iconify-icon icon="lucide:chevron-right" class="text-[18px]"></iconify-icon>
                        </a>
                    @else
                        <button class="p-1.5 rounded-lg border border-gray-200 bg-white text-gray-400 disabled:opacity-50 transition-colors" disabled>
                            <iconify-icon icon="lucide:chevron-right" class="text-[18px]"></iconify-icon>
                        </button>
                    @endif
                </div>
            </div>
        @elseif($returs->total() > 0)
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50/50 flex items-center justify-center mt-auto">
                <span class="text-sm text-gray-500">
                    Menampilkan <span class="font-medium text-gray-900">{{ $returs->total() }}</span> retur
                </span>
            </div>
        @endif
    </div>

    <!-- ===== BOTTOM STATS ===== -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Avg Response -->
        <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-[0_1px_2px_rgba(0,0,0,0.02)] relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-20 h-20 bg-gradient-to-bl from-blue-50 to-transparent rounded-bl-full -z-0 opacity-60 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-3">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Rata-rata Respon</h3>
                    <div class="w-8 h-8 rounded-full bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600">
                        <iconify-icon icon="lucide:clock" class="text-base"></iconify-icon>
                    </div>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-gray-900 tracking-tight">{{ $stats['avg_response'] }}</span>
                    <span class="text-sm text-gray-500 font-medium">Jam</span>
                </div>
            </div>
        </div>

        <!-- Approval Rate -->
        <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-[0_1px_2px_rgba(0,0,0,0.02)] relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-20 h-20 bg-gradient-to-bl from-emerald-50 to-transparent rounded-bl-full -z-0 opacity-60 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-3">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Tingkat Persetujuan</h3>
                    <div class="w-8 h-8 rounded-full bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600">
                        <iconify-icon icon="lucide:check-circle" class="text-base"></iconify-icon>
                    </div>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-gray-900 tracking-tight">{{ $stats['approval_rate'] }}</span>
                    <span class="text-sm text-gray-500 font-medium">%</span>
                </div>
                <div class="mt-2">
                    <div class="w-full bg-gray-100 rounded-full h-1.5">
                        <div class="bg-emerald-500 h-1.5 rounded-full transition-all duration-500" style="width: {{ $stats['approval_rate'] }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Returns This Week -->
        <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-[0_1px_2px_rgba(0,0,0,0.02)] relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-20 h-20 bg-gradient-to-bl from-amber-50 to-transparent rounded-bl-full -z-0 opacity-60 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-3">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Retur Minggu Ini</h3>
                    <div class="w-8 h-8 rounded-full bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-600">
                        <iconify-icon icon="lucide:rotate-ccw" class="text-base"></iconify-icon>
                    </div>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-gray-900 tracking-tight">{{ $stats['returns_this_week'] }}</span>
                    <span class="text-sm text-gray-500 font-medium">pengembalian</span>
                </div>
            </div>
        </div>
    </div>
    <!-- ===== END BOTTOM STATS ===== -->


    <!-- ============================================================ -->
    <!-- ===== MODAL: DETAIL RETUR ===== -->
    <!-- ============================================================ -->
    <div id="detailModal" class="fixed inset-0 z-50 hidden">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black/40 backdrop-blur-sm transition-opacity" onclick="closeDetailModal()"></div>
        <!-- Modal Content -->
        <div class="fixed inset-0 flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto relative animate-modal-in">
                <!-- Header -->
                <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 rounded-t-2xl flex items-center justify-between z-10">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center">
                            <iconify-icon icon="lucide:package-x" class="text-blue-600 text-xl"></iconify-icon>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-gray-900" id="detailKodeReturn">Detail Retur</h2>
                            <p class="text-xs text-gray-500" id="detailTanggal">-</p>
                        </div>
                    </div>
                    <button onclick="closeDetailModal()" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                        <iconify-icon icon="lucide:x" class="text-xl"></iconify-icon>
                    </button>
                </div>

                <!-- Loading State -->
                <div id="detailLoading" class="p-12 flex flex-col items-center gap-3">
                    <div class="w-8 h-8 border-2 border-gray-200 border-t-gray-600 rounded-full animate-spin"></div>
                    <p class="text-sm text-gray-500">Memuat data...</p>
                </div>

                <!-- Body -->
                <div id="detailBody" class="p-6 space-y-6 hidden">
                    <!-- Status Badge -->
                    <div class="flex items-center justify-between">
                        <span id="detailStatusBadge" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold"></span>
                        <span id="detailIdReturn" class="text-xs text-gray-400 font-mono"></span>
                    </div>

                    <!-- Customer Info -->
                    <div class="bg-gray-50 rounded-xl p-4">
                        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Informasi Pelanggan</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <p class="text-[11px] text-gray-400 uppercase tracking-wider">Nama</p>
                                <p class="text-sm font-medium text-gray-900" id="detailNama">-</p>
                            </div>
                            <div>
                                <p class="text-[11px] text-gray-400 uppercase tracking-wider">Email</p>
                                <p class="text-sm text-gray-900" id="detailEmail">-</p>
                            </div>
                            <div>
                                <p class="text-[11px] text-gray-400 uppercase tracking-wider">No. HP</p>
                                <p class="text-sm text-gray-900" id="detailNoHp">-</p>
                            </div>
                            <div>
                                <p class="text-[11px] text-gray-400 uppercase tracking-wider">Alamat</p>
                                <p class="text-sm text-gray-900" id="detailAlamat">-</p>
                            </div>
                        </div>
                    </div>

                    <!-- Order Info -->
                    <div class="bg-gray-50 rounded-xl p-4">
                        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Informasi Pesanan</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <p class="text-[11px] text-gray-400 uppercase tracking-wider">ID Pesanan</p>
                                <p class="text-sm font-medium text-gray-900" id="detailKodePesanan">-</p>
                            </div>
                            <div>
                                <p class="text-[11px] text-gray-400 uppercase tracking-wider">Tanggal Pesanan</p>
                                <p class="text-sm text-gray-900" id="detailTanggalPesanan">-</p>
                            </div>
                            <div>
                                <p class="text-[11px] text-gray-400 uppercase tracking-wider">Total Harga</p>
                                <p class="text-sm font-semibold text-gray-900" id="detailTotalHarga">-</p>
                            </div>
                            <div>
                                <p class="text-[11px] text-gray-400 uppercase tracking-wider">Status Pesanan</p>
                                <p class="text-sm text-gray-900" id="detailStatusPesanan">-</p>
                            </div>
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div class="bg-gray-50 rounded-xl p-4">
                        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Produk Retur</h3>
                        <div class="flex items-center gap-4">
                            <div id="detailProdukImage" class="w-16 h-16 rounded-xl bg-white border border-gray-200 flex items-center justify-center shrink-0 overflow-hidden">
                                <iconify-icon icon="lucide:gem" class="text-gray-300 text-2xl"></iconify-icon>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900" id="detailNamaProduk">-</p>
                                <p class="text-sm text-gray-500" id="detailHargaProduk">-</p>
                            </div>
                        </div>
                    </div>

                    <!-- Return Reason -->
                    <div>
                        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Alasan Pengembalian</h3>
                        <p class="text-sm text-gray-700 bg-gray-50 rounded-xl p-4 leading-relaxed" id="detailAlasan">-</p>
                    </div>

                    <!-- Evidence -->
                    <div id="detailBuktiSection" class="hidden">
                        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Bukti Foto</h3>
                        <div class="bg-gray-50 rounded-xl p-3">
                            <img id="detailBuktiImage" src="" alt="Bukti Retur" class="max-h-64 rounded-lg object-contain mx-auto cursor-pointer hover:opacity-80 transition-opacity" onclick="window.open(this.src)">
                        </div>
                    </div>

                    <!-- Admin Notes -->
                    <div id="detailCatatanSection" class="hidden">
                        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Catatan Admin</h3>
                        <p class="text-sm text-gray-700 bg-rose-50 rounded-xl p-4 leading-relaxed" id="detailCatatanAdmin">-</p>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div id="detailFooter" class="sticky bottom-0 bg-white border-t border-gray-200 px-6 py-4 rounded-b-2xl flex items-center justify-end gap-3 hidden">
                    <button onclick="closeDetailModal()" class="px-4 py-2.5 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-100 transition-colors">
                        Tutup
                    </button>
                    <div id="detailActionsPending" class="hidden flex items-center gap-2">
                        <button onclick="approveFromDetail()" class="flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-600 text-white text-sm font-medium hover:bg-emerald-700 transition-colors">
                            <iconify-icon icon="lucide:check" class="text-base"></iconify-icon>
                            Setujui
                        </button>
                        <button onclick="rejectFromDetail()" class="flex items-center gap-2 px-4 py-2.5 rounded-xl bg-rose-600 text-white text-sm font-medium hover:bg-rose-700 transition-colors">
                            <iconify-icon icon="lucide:x" class="text-base"></iconify-icon>
                            Tolak
                        </button>
                    </div>
                    <div id="detailActionsDiproses" class="hidden">
                        <button onclick="completeFromDetail()" class="flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-600 text-white text-sm font-medium hover:bg-emerald-700 transition-colors">
                            <iconify-icon icon="lucide:check-circle" class="text-base"></iconify-icon>
                            Selesaikan Retur
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- ============================================================ -->
    <!-- ===== MODAL: KONFIRMASI SETUJUI ===== -->
    <!-- ============================================================ -->
    <div id="approveModal" class="fixed inset-0 z-[60] hidden">
        <div class="fixed inset-0 bg-black/40 backdrop-blur-sm" onclick="closeApproveModal()"></div>
        <div class="fixed inset-0 flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md relative animate-modal-in">
                <div class="p-6 text-center">
                    <div class="w-16 h-16 rounded-full bg-emerald-50 flex items-center justify-center mx-auto mb-4">
                        <iconify-icon icon="lucide:check-circle" class="text-emerald-500 text-3xl"></iconify-icon>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Setujui Pengembalian?</h3>
                    <p class="text-sm text-gray-500 mb-1">Anda akan menyetujui retur</p>
                    <p class="text-sm font-semibold text-gray-900 mb-6" id="approveKodeReturn">-</p>
                    <p class="text-xs text-gray-400 mb-6">Status retur akan berubah menjadi <span class="font-semibold text-blue-600">Diproses</span></p>
                    <div class="flex items-center gap-3">
                        <button onclick="closeApproveModal()" class="flex-1 px-4 py-2.5 rounded-xl border border-gray-200 text-sm font-medium text-gray-600 hover:bg-gray-50 transition-colors">
                            Batal
                        </button>
                        <button onclick="submitApprove()" id="approveBtn" class="flex-1 px-4 py-2.5 rounded-xl bg-emerald-600 text-white text-sm font-medium hover:bg-emerald-700 transition-colors">
                            Ya, Setujui
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- ============================================================ -->
    <!-- ===== MODAL: TOLAK DENGAN CATATAN ===== -->
    <!-- ============================================================ -->
    <div id="rejectModal" class="fixed inset-0 z-[60] hidden">
        <div class="fixed inset-0 bg-black/40 backdrop-blur-sm" onclick="closeRejectModal()"></div>
        <div class="fixed inset-0 flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md relative animate-modal-in">
                <div class="p-6">
                    <div class="text-center mb-4">
                        <div class="w-16 h-16 rounded-full bg-rose-50 flex items-center justify-center mx-auto mb-4">
                            <iconify-icon icon="lucide:x-circle" class="text-rose-500 text-3xl"></iconify-icon>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Tolak Pengembalian?</h3>
                        <p class="text-sm text-gray-500 mb-1">Anda akan menolak retur</p>
                        <p class="text-sm font-semibold text-gray-900" id="rejectKodeReturn">-</p>
                    </div>

                    <div class="mb-6">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Catatan Penolakan <span class="text-rose-500">*</span></label>
                        <textarea id="rejectCatatan" rows="3" placeholder="Berikan alasan penolakan retur ini..." class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-400 resize-none placeholder:text-gray-400"></textarea>
                        <p id="rejectCatatanError" class="text-xs text-rose-500 mt-1 hidden">Catatan penolakan wajib diisi.</p>
                    </div>

                    <div class="flex items-center gap-3">
                        <button onclick="closeRejectModal()" class="flex-1 px-4 py-2.5 rounded-xl border border-gray-200 text-sm font-medium text-gray-600 hover:bg-gray-50 transition-colors">
                            Batal
                        </button>
                        <button onclick="submitReject()" id="rejectBtn" class="flex-1 px-4 py-2.5 rounded-xl bg-rose-600 text-white text-sm font-medium hover:bg-rose-700 transition-colors">
                            Ya, Tolak
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- ============================================================ -->
    <!-- ===== MODAL: KONFIRMASI SELESAIKAN ===== -->
    <!-- ============================================================ -->
    <div id="completeModal" class="fixed inset-0 z-[60] hidden">
        <div class="fixed inset-0 bg-black/40 backdrop-blur-sm" onclick="closeCompleteModal()"></div>
        <div class="fixed inset-0 flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md relative animate-modal-in">
                <div class="p-6 text-center">
                    <div class="w-16 h-16 rounded-full bg-emerald-50 flex items-center justify-center mx-auto mb-4">
                        <iconify-icon icon="lucide:check-circle-2" class="text-emerald-500 text-3xl"></iconify-icon>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Selesaikan Retur?</h3>
                    <p class="text-sm text-gray-500 mb-1">Anda akan menyelesaikan retur</p>
                    <p class="text-sm font-semibold text-gray-900 mb-6" id="completeKodeReturn">-</p>
                    <p class="text-xs text-gray-400 mb-6">Status retur akan berubah menjadi <span class="font-semibold text-emerald-600">Selesai</span></p>
                    <div class="flex items-center gap-3">
                        <button onclick="closeCompleteModal()" class="flex-1 px-4 py-2.5 rounded-xl border border-gray-200 text-sm font-medium text-gray-600 hover:bg-gray-50 transition-colors">
                            Batal
                        </button>
                        <button onclick="submitComplete()" id="completeBtn" class="flex-1 px-4 py-2.5 rounded-xl bg-emerald-600 text-white text-sm font-medium hover:bg-emerald-700 transition-colors">
                            Ya, Selesaikan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- ===== TOAST NOTIFICATION ===== -->
    <div id="toast" class="fixed bottom-6 right-6 z-[100] hidden">
        <div id="toastContent" class="flex items-center gap-3 px-5 py-4 rounded-xl shadow-2xl text-sm font-medium animate-toast-in">
            <iconify-icon id="toastIcon" icon="" class="text-xl shrink-0"></iconify-icon>
            <span id="toastMessage">-</span>
        </div>
    </div>

@endsection


@push('styles')
<style>
    @keyframes modal-in {
        from { opacity: 0; transform: scale(0.95) translateY(10px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }
    @keyframes toast-in {
        from { opacity: 0; transform: translateX(20px); }
        to { opacity: 1; transform: translateX(0); }
    }
    .animate-modal-in { animation: modal-in 0.2s ease-out; }
    .animate-toast-in { animation: toast-in 0.3s ease-out; }
</style>
@endpush

@push('scripts')
<script>
    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    let currentReturId = null;
    let currentReturStatus = null;

    // ========== TOAST ==========
    function showToast(message, type = 'success') {
        const toast = document.getElementById('toast');
        const content = document.getElementById('toastContent');
        const icon = document.getElementById('toastIcon');
        const msg = document.getElementById('toastMessage');

        msg.textContent = message;

        const config = {
            success: { bg: 'bg-emerald-600 text-white', icon: 'lucide:check-circle' },
            error:   { bg: 'bg-rose-600 text-white',    icon: 'lucide:alert-circle' },
            info:    { bg: 'bg-blue-600 text-white',     icon: 'lucide:info' },
        }[type] || { bg: 'bg-gray-800 text-white', icon: 'lucide:info' };

        content.className = `flex items-center gap-3 px-5 py-4 rounded-xl shadow-2xl text-sm font-medium animate-toast-in ${config.bg}`;
        icon.setAttribute('icon', config.icon);

        toast.classList.remove('hidden');
        setTimeout(() => { toast.classList.add('hidden'); }, 4000);
    }

    // ========== AJAX HELPER ==========
    async function ajaxPut(url) {
        const res = await fetch(url, {
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
        });
        return res;
    }

    async function ajaxPutWithBody(url, body) {
        const res = await fetch(url, {
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(body),
        });
        return res;
    }

    // ========== DETAIL MODAL ==========
    function openDetailModal(id) {
        const modal = document.getElementById('detailModal');
        const loading = document.getElementById('detailLoading');
        const body = document.getElementById('detailBody');
        const footer = document.getElementById('detailFooter');

        loading.classList.remove('hidden');
        body.classList.add('hidden');
        footer.classList.add('hidden');
        modal.classList.remove('hidden');

        currentReturId = id;

        fetch(`{{ route('admin.retur.index', []) }}/${id}`, {
            headers: { 'Accept': 'application/json' }
        })
        .then(res => res.json())
        .then(data => {
            currentReturStatus = data.status_return;

            // Header
            document.getElementById('detailKodeReturn').textContent = data.kode_return;
            document.getElementById('detailTanggal').textContent = 'Diajukan: ' + data.tanggal_pengajuan;
            document.getElementById('detailIdReturn').textContent = 'ID: ' + data.id_return;

            // Status badge
            const badge = document.getElementById('detailStatusBadge');
            const colorMap = {
                pending: 'amber', diproses: 'blue', selesai: 'emerald', ditolak: 'rose'
            };
            const c = colorMap[data.status_return] || 'gray';
            badge.className = `inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-${c}-50 text-${c}-700 border border-${c}-100/50`;
            badge.innerHTML = `<span class="w-1.5 h-1.5 rounded-full bg-${c}-500"></span> ${data.status_label}`;

            // Customer
            document.getElementById('detailNama').textContent = data.user.nama;
            document.getElementById('detailEmail').textContent = data.user.email;
            document.getElementById('detailNoHp').textContent = data.user.no_hp || '-';
            document.getElementById('detailAlamat').textContent = data.user.alamat || '-';

            // Order
            document.getElementById('detailKodePesanan').textContent = data.pesanan.kode_pesanan;
            document.getElementById('detailTanggalPesanan').textContent = data.pesanan.tanggal_pesanan;
            document.getElementById('detailTotalHarga').textContent = data.pesanan.total_harga;
            document.getElementById('detailStatusPesanan').textContent = data.pesanan.status_pesanan;

            // Product
            document.getElementById('detailNamaProduk').textContent = data.produk.nama_produk;
            document.getElementById('detailHargaProduk').textContent = data.produk.harga;

            const imgContainer = document.getElementById('detailProdukImage');
            if (data.produk.gambar_url) {
                imgContainer.innerHTML = `<img src="${data.produk.gambar_url}" class="w-full h-full object-cover rounded-xl" alt="">`;
            } else {
                imgContainer.innerHTML = '<iconify-icon icon="lucide:gem" class="text-gray-300 text-2xl"></iconify-icon>';
            }

            // Reason
            document.getElementById('detailAlasan').textContent = data.alasan_return;

            // Evidence
            const buktiSection = document.getElementById('detailBuktiSection');
            if (data.bukti_return_url) {
                document.getElementById('detailBuktiImage').src = data.bukti_return_url;
                buktiSection.classList.remove('hidden');
            } else {
                buktiSection.classList.add('hidden');
            }

            // Admin notes
            const catatanSection = document.getElementById('detailCatatanSection');
            if (data.catatan_admin) {
                document.getElementById('detailCatatanAdmin').textContent = data.catatan_admin;
                catatanSection.classList.remove('hidden');
            } else {
                catatanSection.classList.add('hidden');
            }

            // Actions
            document.getElementById('detailActionsPending').classList.add('hidden');
            document.getElementById('detailActionsDiproses').classList.add('hidden');

            if (data.status_return === 'pending') {
                document.getElementById('detailActionsPending').classList.remove('hidden');
            } else if (data.status_return === 'diproses') {
                document.getElementById('detailActionsDiproses').classList.remove('hidden');
            }

            loading.classList.add('hidden');
            body.classList.remove('hidden');
            footer.classList.remove('hidden');
        })
        .catch(err => {
            showToast('Gagal memuat data retur.', 'error');
            closeDetailModal();
        });
    }

    function closeDetailModal() {
        document.getElementById('detailModal').classList.add('hidden');
        currentReturId = null;
        currentReturStatus = null;
    }

    // Actions from detail modal
    function approveFromDetail() {
        if (!currentReturId) return;
        closeDetailModal();
        openApproveModal(currentReturId, document.getElementById('detailKodeReturn').textContent);
    }

    function rejectFromDetail() {
        if (!currentReturId) return;
        closeDetailModal();
        openRejectModal(currentReturId, document.getElementById('detailKodeReturn').textContent);
    }

    function completeFromDetail() {
        if (!currentReturId) return;
        closeDetailModal();
        openCompleteModal(currentReturId, document.getElementById('detailKodeReturn').textContent);
    }


    // ========== APPROVE MODAL ==========
    function openApproveModal(id, kode) {
        currentReturId = id;
        document.getElementById('approveKodeReturn').textContent = kode;
        document.getElementById('approveModal').classList.remove('hidden');
    }

    function closeApproveModal() {
        document.getElementById('approveModal').classList.add('hidden');
    }

    async function submitApprove() {
        const btn = document.getElementById('approveBtn');
        btn.disabled = true;
        btn.innerHTML = '<span class="inline-block w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></span> Memproses...';

        try {
            const res = await ajaxPut(`{{ route('admin.retur.index', []) }}/${currentReturId}/approve`);
            const data = await res.json();

            if (res.ok) {
                showToast(data.success, 'success');
                closeApproveModal();
                setTimeout(() => location.reload(), 800);
            } else {
                showToast(data.error || 'Gagal menyetujui retur.', 'error');
                btn.disabled = false;
                btn.innerHTML = 'Ya, Setujui';
            }
        } catch (err) {
            showToast('Terjadi kesalahan.', 'error');
            btn.disabled = false;
            btn.innerHTML = 'Ya, Setujui';
        }
    }


    // ========== REJECT MODAL ==========
    function openRejectModal(id, kode) {
        currentReturId = id;
        document.getElementById('rejectKodeReturn').textContent = kode;
        document.getElementById('rejectCatatan').value = '';
        document.getElementById('rejectCatatanError').classList.add('hidden');
        document.getElementById('rejectModal').classList.remove('hidden');
    }

    function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
    }

    async function submitReject() {
        const catatan = document.getElementById('rejectCatatan').value.trim();
        const errorEl = document.getElementById('rejectCatatanError');

        if (!catatan) {
            errorEl.classList.remove('hidden');
            document.getElementById('rejectCatatan').focus();
            return;
        }
        errorEl.classList.add('hidden');

        const btn = document.getElementById('rejectBtn');
        btn.disabled = true;
        btn.innerHTML = '<span class="inline-block w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></span> Memproses...';

        try {
            const res = await ajaxPutWithBody(`{{ route('admin.retur.index', []) }}/${currentReturId}/reject`, {
                catatan_admin: catatan
            });
            const data = await res.json();

            if (res.ok) {
                showToast(data.success, 'success');
                closeRejectModal();
                setTimeout(() => location.reload(), 800);
            } else {
                showToast(data.error || 'Gagal menolak retur.', 'error');
                btn.disabled = false;
                btn.innerHTML = 'Ya, Tolak';
            }
        } catch (err) {
            showToast('Terjadi kesalahan.', 'error');
            btn.disabled = false;
            btn.innerHTML = 'Ya, Tolak';
        }
    }


    // ========== COMPLETE MODAL ==========
    function openCompleteModal(id, kode) {
        currentReturId = id;
        document.getElementById('completeKodeReturn').textContent = kode;
        document.getElementById('completeModal').classList.remove('hidden');
    }

    function closeCompleteModal() {
        document.getElementById('completeModal').classList.add('hidden');
    }

    async function submitComplete() {
        const btn = document.getElementById('completeBtn');
        btn.disabled = true;
        btn.innerHTML = '<span class="inline-block w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></span> Memproses...';

        try {
            const res = await ajaxPut(`{{ route('admin.retur.index', []) }}/${currentReturId}/complete`);
            const data = await res.json();

            if (res.ok) {
                showToast(data.success, 'success');
                closeCompleteModal();
                setTimeout(() => location.reload(), 800);
            } else {
                showToast(data.error || 'Gagal menyelesaikan retur.', 'error');
                btn.disabled = false;
                btn.innerHTML = 'Ya, Selesaikan';
            }
        } catch (err) {
            showToast('Terjadi kesalahan.', 'error');
            btn.disabled = false;
            btn.innerHTML = 'Ya, Selesaikan';
        }
    }


    // ========== KEYBOARD SHORTCUT ==========
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeDetailModal();
            closeApproveModal();
            closeRejectModal();
            closeCompleteModal();
        }
    });
</script>
@endpush