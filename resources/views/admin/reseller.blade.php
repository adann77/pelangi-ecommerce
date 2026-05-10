@extends('layouts.admin')

@section('pageTitle', 'Kelola Reseller — Pelangi Accessories Admin')

@section('nav-reseller', 'active')

@section('headerTitle', 'Kelola Reseller')

@section('headerActions')
@endsection

@section('content')

    <!-- ===== TOP STATS ===== -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

        <!-- Total Pendaftar -->
        <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-[0_1px_2px_rgba(0,0,0,0.02)] relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-20 h-20 bg-gradient-to-bl from-blue-50 to-transparent rounded-bl-full -z-0 opacity-60 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-3">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Pendaftar</h3>
                    <div class="w-8 h-8 rounded-full bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600">
                        <iconify-icon icon="lucide:users" class="text-base"></iconify-icon>
                    </div>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-gray-900 tracking-tight">{{ $total }}</span>
                </div>
            </div>
        </div>

        <!-- Menunggu Persetujuan -->
        <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-[0_1px_2px_rgba(0,0,0,0.02)] relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-20 h-20 bg-gradient-to-bl from-amber-50 to-transparent rounded-bl-full -z-0 opacity-60 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-3">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Menunggu Persetujuan</h3>
                    <div class="w-8 h-8 rounded-full bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-600">
                        <iconify-icon icon="lucide:clock" class="text-base"></iconify-icon>
                    </div>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-gray-900 tracking-tight">{{ $pending }}</span>
                </div>
                <div class="mt-2">
                    <div class="w-full bg-gray-100 rounded-full h-1.5">
                        <div class="bg-amber-500 h-1.5 rounded-full" style="width: {{ $total > 0 ? ($pending/$total)*100 : 0 }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reseller Aktif -->
        <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-[0_1px_2px_rgba(0,0,0,0.02)] relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-20 h-20 bg-gradient-to-bl from-emerald-50 to-transparent rounded-bl-full -z-0 opacity-60 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-3">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Reseller Aktif</h3>
                    <div class="w-8 h-8 rounded-full bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600">
                        <iconify-icon icon="lucide:store" class="text-base"></iconify-icon>
                    </div>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-gray-900 tracking-tight">{{ $approved }}</span>
                </div>
                <div class="mt-2">
                    <div class="w-full bg-gray-100 rounded-full h-1.5">
                        <div class="bg-emerald-500 h-1.5 rounded-full" style="width: {{ $total > 0 ? ($approved/$total)*100 : 0 }}%"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- ===== END TOP STATS ===== -->

    <!-- Flash Message -->
    @if(session('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
             class="mb-4 p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-sm text-emerald-700 flex items-center gap-2 transition-opacity">
            <iconify-icon icon="lucide:check-circle" class="text-lg"></iconify-icon>
            {{ session('success') }}
        </div>
    @endif

    <!-- Data Table -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-[0_1px_2px_rgba(0,0,0,0.02)] flex-1 flex flex-col overflow-hidden mb-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/80 border-b border-gray-200">
                        <th class="px-5 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">ID</th>
                        <th class="px-5 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Nama & Email</th>
                        <th class="px-5 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">WhatsApp</th>
                        <th class="px-5 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Tanggal</th>
                        <th class="px-5 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Pembayaran</th>
                        <th class="px-5 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Status</th>
                        <th class="px-5 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    
                    @forelse($resellers as $reseller)
                    @php 
                        $initials = collect(explode(' ', $reseller->nama))->take(2)->map(fn($word) => strtoupper(substr($word, 0, 1)))->join('');
                        $colors = ['purple', 'blue', 'emerald', 'rose', 'amber', 'indigo', 'cyan'];
                        $color = $colors[$reseller->id_user % count($colors)];
                        $currentStatus = $reseller->status_reseller ?? 'pending';
                    @endphp

                    <tr class="hover:bg-gray-50/60 transition-colors group">
                        <td class="px-5 py-4"><span class="text-sm font-semibold text-gray-900 whitespace-nowrap">#RS-{{ str_pad($reseller->id_user, 3, '0', STR_PAD_LEFT) }}</span></td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-{{ $color }}-50 flex items-center justify-center border border-{{ $color }}-100 shrink-0 text-xs font-bold text-{{ $color }}-600">
                                    {{ $initials }}
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900 whitespace-nowrap">{{ $reseller->nama }}</p>
                                    <p class="text-xs text-gray-500 whitespace-nowrap">{{ $reseller->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4"><span class="text-sm text-gray-600 whitespace-nowrap">{{ $reseller->no_hp ?? '-' }}</span></td>
                        <td class="px-5 py-4"><span class="text-sm text-gray-500 whitespace-nowrap">{{ $reseller->created_at->format('d M Y') }}</span></td>
                        <td class="px-5 py-4">
                            @if($reseller->bukti_pembayaran)
                                <a href="{{ asset('storage/' . $reseller->bukti_pembayaran) }}" target="_blank" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-100/50 whitespace-nowrap hover:bg-emerald-100 transition-colors">
                                    <iconify-icon icon="lucide:check-circle" class="text-[10px]"></iconify-icon> Lihat Bukti
                                </a>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium bg-amber-50 text-amber-700 border border-amber-100/50 whitespace-nowrap">
                                    <iconify-icon icon="lucide:clock" class="text-[10px]"></iconify-icon> Belum Bayar
                                </span>
                            @endif
                        </td>
                        
                        <!-- KOLOM STATUS -->
                        <td class="px-5 py-4">
                            @if($currentStatus === 'approved')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100/50 whitespace-nowrap">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Disetujui
                                </span>
                            @elseif($currentStatus === 'rejected')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-100/50 whitespace-nowrap">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Ditolak
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-100/50 whitespace-nowrap">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Menunggu
                                </span>
                            @endif
                        </td>

                        <!-- KOLOM AKSI -->
                        <td class="px-5 py-4">
                            <div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                
                                {{-- Tombol Detail (Selalu Aktif) --}}
                                <button onclick="showDetail(@json($reseller))" class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Detail">
                                    <iconify-icon icon="lucide:eye" class="text-[16px]"></iconify-icon>
                                </button>

                                {{-- Tombol Setujui (Nonaktif jika sudah Disetujui) --}}
                                <form action="{{ route('admin.reseller.approve', $reseller->id_user) }}" method="POST">
                                    @csrf @method('PUT')
                                    <button type="submit" 
                                        class="p-2 rounded-lg transition-colors @if($currentStatus === 'approved') text-gray-300 cursor-not-allowed @else text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 @endif" 
                                        title="Setujui"
                                        @if($currentStatus === 'approved') disabled @endif>
                                        <iconify-icon icon="lucide:check" class="text-[16px]"></iconify-icon>
                                    </button>
                                </form>

                                {{-- Tombol Tolak (Nonaktif jika sudah Ditolak) --}}
                                <form action="{{ route('admin.reseller.reject', $reseller->id_user) }}" method="POST">
                                    @csrf @method('PUT')
                                    <button type="submit" 
                                        class="p-2 rounded-lg transition-colors @if($currentStatus === 'rejected') text-gray-300 cursor-not-allowed @else text-gray-400 hover:text-rose-600 hover:bg-rose-50 @endif" 
                                        title="Tolak"
                                        @if($currentStatus === 'rejected') disabled @endif>
                                        <iconify-icon icon="lucide:x" class="text-[16px]"></iconify-icon>
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-10 text-gray-400 text-sm">Belum ada pendaftar reseller.</td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        <!-- Pagination Footer -->
        <div class="px-5 py-4 border-t border-gray-200 bg-gray-50/50 flex flex-col sm:flex-row items-center justify-between gap-4 mt-auto">
            <span class="text-sm text-gray-500">Menampilkan <span class="font-medium text-gray-900">{{ $resellers->count() }}</span> pendaftar</span>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    function showDetail(reseller) {
        alert(
            `Detail Reseller:\n\n` +
            `Nama: ${reseller.nama}\n` +
            `Email: ${reseller.email}\n` +
            `No HP: ${reseller.no_hp || '-'}\n` +
            `Alamat: ${reseller.alamat || '-'}\n` +
            `Status: ${reseller.status_reseller === 'approved' ? 'Disetujui' : reseller.status_reseller === 'rejected' ? 'Ditolak' : 'Menunggu'}`
        );
    }
</script>
@endpush