@extends('layouts.admin')

@section('pageTitle', 'Manajemen Pengiriman — Pelangi Accessories Admin')

@section('nav-pengiriman', 'active')

@section('headerTitle', 'Pengiriman Barang')

@section('headerActions')
    
@endsection

@section('content')
<button class="flex items-center gap-2 px-4 py-2.5 rounded-xl bg-gray-900 text-white text-sm font-medium hover:bg-gray-800 transition-all shadow-sm active:scale-[0.98]">
        <iconify-icon icon="lucide:download" class="text-lg"></iconify-icon>
        Export Data
    </button>
    <!-- ===== STATUS METRICS ===== -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

        <!-- Card: Perlu Dikirim -->
        <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-[0_1px_2px_rgba(0,0,0,0.02)] relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-20 h-20 bg-gradient-to-bl from-amber-50 to-transparent rounded-bl-full -z-0 opacity-60 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-3">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Perlu Dikirim</h3>
                    <div class="w-8 h-8 rounded-full bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-600">
                        <iconify-icon icon="lucide:clock" class="text-base"></iconify-icon>
                    </div>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-gray-900 tracking-tight">{{ $perluDikirimCount }}</span>
                    <span class="text-xs text-gray-400 font-medium">pesanan</span>
                </div>
                <div class="mt-2">
                    <div class="w-full bg-gray-100 rounded-full h-1.5">
                        <div class="bg-amber-500 h-1.5 rounded-full" style="width: {{ $totalCount ? round(($perluDikirimCount / $totalCount) * 100) : 0 }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card: Dalam Perjalanan -->
        <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-[0_1px_2px_rgba(0,0,0,0.02)] relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-20 h-20 bg-gradient-to-bl from-blue-50 to-transparent rounded-bl-full -z-0 opacity-60 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-3">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Dalam Perjalanan</h3>
                    <div class="w-8 h-8 rounded-full bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600">
                        <iconify-icon icon="lucide:truck" class="text-base"></iconify-icon>
                    </div>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-gray-900 tracking-tight">{{ $dalamPerjalananCount }}</span>
                    <span class="text-xs text-gray-400 font-medium">pesanan</span>
                </div>
                <div class="mt-2">
                    <div class="w-full bg-gray-100 rounded-full h-1.5">
                        <div class="bg-blue-500 h-1.5 rounded-full" style="width: {{ $totalCount ? round(($dalamPerjalananCount / $totalCount) * 100) : 0 }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card: Selesai -->
        <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-[0_1px_2px_rgba(0,0,0,0.02)] relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-20 h-20 bg-gradient-to-bl from-emerald-50 to-transparent rounded-bl-full -z-0 opacity-60 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-3">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Selesai</h3>
                    <div class="w-8 h-8 rounded-full bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600">
                        <iconify-icon icon="lucide:check-circle" class="text-base"></iconify-icon>
                    </div>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-gray-900 tracking-tight">{{ $selesaiCount }}</span>
                    <span class="text-xs text-gray-400 font-medium">pesanan</span>
                </div>
                <div class="mt-2">
                    <div class="w-full bg-gray-100 rounded-full h-1.5">
                        <div class="bg-emerald-500 h-1.5 rounded-full" style="width: {{ $totalCount ? round(($selesaiCount / $totalCount) * 100) : 0 }}%"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- ===== END STATUS METRICS ===== -->

    <!-- Search and Filter Bar -->
    <form method="GET" action="{{ route('admin.pengiriman.index') }}" class="bg-white p-2 rounded-2xl border border-gray-200 shadow-[0_1px_2px_rgba(0,0,0,0.02)] mb-6 flex flex-col sm:flex-row gap-2">
        <div class="relative flex-1">
            <iconify-icon icon="lucide:search" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-lg"></iconify-icon>
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari order ID, nama pelanggan, atau no. resi..." class="w-full pl-11 pr-4 py-2.5 bg-transparent text-sm focus:outline-none placeholder:text-gray-400 text-gray-900">
        </div>
        <div class="hidden sm:block w-px bg-gray-200 my-2"></div>
        <select name="status" class="flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-xl transition-colors bg-transparent border-0 focus:outline-none focus:ring-0 cursor-pointer appearance-none">
            <option value="">Semua Status</option>
            <option value="perlu_dikirim" {{ $status === 'perlu_dikirim' ? 'selected' : '' }}>Perlu Dikirim</option>
            <option value="dalam_perjalanan" {{ $status === 'dalam_perjalanan' ? 'selected' : '' }}>Dalam Perjalanan</option>
            <option value="selesai" {{ $status === 'selesai' ? 'selected' : '' }}>Selesai</option>
        </select>
        <button type="submit" class="flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-white bg-gray-900 hover:bg-gray-800 rounded-xl transition-colors">
            <iconify-icon icon="lucide:search" class="text-sm"></iconify-icon>
            Cari
        </button>
    </form>

    <!-- Data Table -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-[0_1px_2px_rgba(0,0,0,0.02)] flex-1 flex flex-col overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/80 border-b border-gray-200">
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Order ID</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Nama Pelanggan</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Tanggal</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Kurir</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Ongkir</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">No. Resi</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Status</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">

                    @forelse ($pengiriman as $item)
                    <tr class="hover:bg-gray-50/60 transition-colors group">
                        {{-- Order ID --}}
                        <td class="px-6 py-4">
                            <span class="text-sm font-semibold text-gray-900 whitespace-nowrap">#PA-{{ str_pad($item->pesanan_id, 3, '0', STR_PAD_LEFT) }}</span>
                        </td>

                        {{-- Nama Pelanggan --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center border border-gray-200 shrink-0 text-xs font-bold text-gray-500">
                                    {{ $item->inisial_pelanggan }}
                                </div>
                                <span class="text-sm font-medium text-gray-900 whitespace-nowrap">{{ $item->pesanan?->user?->name ?? '-' }}</span>
                            </div>
                        </td>

                        {{-- Tanggal --}}
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-600 whitespace-nowrap">
                                {{ $item->pesanan?->tanggal_pesanan
                                    ? \Carbon\Carbon::parse($item->pesanan->tanggal_pesanan)->format('d M Y')
                                    : $item->created_at->format('d M Y') }}
                            </span>
                        </td>

                        {{-- Kurir --}}
                        <td class="px-6 py-4">
                            @php $kurirColor = $item->kurir_color; @endphp
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-md bg-{{ $kurirColor }}-50 border border-{{ $kurirColor }}-100 flex items-center justify-center">
                                    <iconify-icon icon="lucide:truck" class="text-{{ $kurirColor }}-500 text-xs"></iconify-icon>
                                </div>
                                <span class="text-sm text-gray-700 font-medium whitespace-nowrap">{{ $item->kurir }} {{ $item->layanan }}</span>
                            </div>
                        </td>

                        {{-- Ongkir --}}
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-600 font-medium whitespace-nowrap">{{ $item->ongkir_rupiah }}</span>
                        </td>

                        {{-- No. Resi --}}
                        <td class="px-6 py-4">
                            @if($item->no_resi)
                                <span class="text-sm text-gray-500 font-mono whitespace-nowrap">{{ $item->no_resi }}</span>
                            @else
                                <span class="text-sm text-gray-400 font-mono italic whitespace-nowrap">Belum ada</span>
                            @endif
                        </td>

                        {{-- Status --}}
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold border {{ $item->pengiriman_status_badge }} whitespace-nowrap">
                                <span class="w-1.5 h-1.5 rounded-full {{ $item->pengiriman_status_dot }}"></span>
                                {{ $item->pengiriman_status_label }}
                            </span>
                        </td>

                        {{-- Aksi --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('admin.pengiriman.show', $item->id) }}" class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Detail">
                                    <iconify-icon icon="lucide:eye" class="text-[16px]"></iconify-icon>
                                </a>
                                <button type="button"
                                    onclick="openUpdateModal(
                                        {{ $item->id }},
                                        '{{ addslashes($item->no_resi ?? '') }}',
                                        '{{ $item->status }}',
                                        '{{ $item->kurir }}',
                                        '{{ addslashes($item->layanan ?? '') }}',
                                        '{{ $item->ongkir }}'
                                    )"
                                    class="p-2 text-gray-400 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-colors"
                                    title="Update Pengiriman">
                                    <iconify-icon icon="lucide:edit-2" class="text-[16px]"></iconify-icon>
                                </button>
                            </div>
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center text-gray-400 text-sm">
                            <iconify-icon icon="lucide:package-x" class="text-4xl mb-2 block mx-auto text-gray-300"></iconify-icon>
                            Belum ada data pengiriman.
                        </td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        <!-- Pagination Footer -->
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50/50 flex flex-col sm:flex-row items-center justify-between gap-4 mt-auto">
            <span class="text-sm text-gray-500">
                Menampilkan
                <span class="font-medium text-gray-900">{{ $pengiriman->firstItem() ?? 0 }}-{{ $pengiriman->lastItem() ?? 0 }}</span>
                dari
                <span class="font-medium text-gray-900">{{ $pengiriman->total() }}</span>
                pengiriman
            </span>
            <div class="flex items-center gap-1.5">
                {{ $pengiriman->links('pagination::tailwind') }}
            </div>
        </div>
    </div>

    <!-- ===== MODAL UPDATE PENGIRIMAN ===== -->
    <div id="updateModal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeUpdateModal()"></div>
        <div class="relative flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 relative z-10">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-bold text-gray-900">Update Pengiriman</h3>
                    <button onclick="closeUpdateModal()" class="p-1.5 text-gray-400 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors">
                        <iconify-icon icon="lucide:x" class="text-lg"></iconify-icon>
                    </button>
                </div>
                <form id="updateForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="space-y-4">
                        <!-- Kurir -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kurir</label>
                            <select name="kurir" id="modalKurir" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-400">
                                <option value="JNE">JNE</option>
                                <option value="J&T">J&T</option>
                                <option value="SiCepat">SiCepat</option>
                                <option value="AnterAja">AnterAja</option>
                                <option value="Tiki">Tiki</option>
                            </select>
                        </div>
                        <!-- Layanan -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Layanan</label>
                            <input type="text" name="layanan" id="modalLayanan" placeholder="REG, EZ, BEST..." class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-400">
                        </div>
                        <!-- Ongkir -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Ongkir (Rp)</label>
                            <input type="number" name="ongkir" id="modalOngkir" min="0" step="500" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-400">
                        </div>
                        <!-- No. Resi -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">No. Resi</label>
                            <input type="text" name="no_resi" id="modalNoResi" placeholder="Masukkan nomor resi..." class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-400 font-mono">
                        </div>
                        <!-- Status -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select name="status" id="modalStatus" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-400">
                                <option value="perlu_dikirim">Perlu Dikirim</option>
                                <option value="dalam_perjalanan">Dalam Perjalanan</option>
                                <option value="selesai">Selesai</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex gap-3 mt-6">
                        <button type="button" onclick="closeUpdateModal()" class="flex-1 px-4 py-2.5 border border-gray-200 text-gray-700 rounded-xl text-sm font-medium hover:bg-gray-50 transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="flex-1 px-4 py-2.5 bg-gray-900 text-white rounded-xl text-sm font-medium hover:bg-gray-800 transition-colors">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openUpdateModal(id, noResi, status, kurir, layanan, ongkir) {
            const baseUrl = '{{ url("admin/pengiriman") }}';
            document.getElementById('updateForm').action = `${baseUrl}/${id}`;

            document.getElementById('modalNoResi').value   = noResi && noResi !== 'null' ? noResi : '';
            document.getElementById('modalStatus').value   = status || 'perlu_dikirim';
            document.getElementById('modalKurir').value    = kurir || 'JNE';
            document.getElementById('modalLayanan').value  = layanan && layanan !== 'null' ? layanan : '';
            document.getElementById('modalOngkir').value   = ongkir || 0;

            document.getElementById('updateModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeUpdateModal() {
            document.getElementById('updateModal').classList.add('hidden');
            document.body.style.overflow = '';
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeUpdateModal();
        });
    </script>

@endsection