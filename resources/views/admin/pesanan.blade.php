@extends('layouts.admin')

@section('pageTitle', 'Manajemen Pesanan — Pelangi Accessories Admin')

@section('nav-pesanan', 'active')

@section('headerTitle', 'Pemesanan')

@section('headerActions')
  
@endsection

@section('content')
  <button class="flex items-center gap-2 px-4 py-2.5 rounded-xl bg-gray-900 text-white text-sm font-medium hover:bg-gray-800 transition-all shadow-sm active:scale-[0.98]">
        <iconify-icon icon="lucide:download" class="text-lg"></iconify-icon>
        Export Data
    </button>
    <!-- Search and Filter Bar -->
    <form action="{{ route('admin.pesanan.index') }}" method="GET" class="bg-white p-2 rounded-2xl border border-gray-200 shadow-[0_1px_2px_rgba(0,0,0,0.02)] mb-6 flex flex-col sm:flex-row gap-2">
        <div class="relative flex-1">
            <iconify-icon icon="lucide:search" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-lg"></iconify-icon>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari ID pesanan, nama pelanggan..." class="w-full pl-11 pr-4 py-2.5 bg-transparent text-sm focus:outline-none placeholder:text-gray-400 text-gray-900">
        </div>
        <div class="hidden sm:block w-px bg-gray-200 my-2"></div>
        <div class="flex items-center gap-2">
            <select name="status" onchange="this.form.submit()" class="px-4 py-2.5 bg-transparent text-sm font-medium text-gray-600 focus:outline-none cursor-pointer">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                <option value="dikirim" {{ request('status') == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
            </select>
            <button type="submit" class="flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-xl transition-colors">
                <iconify-icon icon="lucide:filter" class="text-gray-400"></iconify-icon>
                Filter
            </button>
        </div>
    </form>

    <!-- Data Table -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-[0_1px_2px_rgba(0,0,0,0.02)] flex-1 flex flex-col overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/80 border-b border-gray-200">
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">ID Pesanan</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Tanggal</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Pelanggan</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Total</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Status</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($pesanan as $item)
                    @php
                        // Inisial Nama
                        $nameParts = explode(' ', $item->user->nama);
                        $initials = strtoupper(substr($nameParts[0], 0, 1)) . (count($nameParts) > 1 ? strtoupper(substr($nameParts[1], 0, 1)) : '');
                        
                        // Warna avatar
                        $colors = ['blue', 'purple', 'emerald', 'rose', 'amber'];
                        $color = $colors[$item->id_pesanan % count($colors)];

                        // Config Status Badge
                        $statusConfig = [
                            'pending'      => ['bg' => 'bg-gray-100', 'text' => 'text-gray-600', 'border' => 'border-gray-200/50', 'dot' => 'bg-gray-400', 'label' => 'Pending'],
                            'diproses'     => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'border' => 'border-amber-100/50', 'dot' => 'bg-amber-500', 'label' => 'Diproses'],
                            'dikirim'      => ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'border' => 'border-blue-100/50', 'dot' => 'bg-blue-500', 'label' => 'Dikirim'],
                            'selesai'      => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-100/50', 'dot' => 'bg-emerald-500', 'label' => 'Selesai'],
                            'dibatalkan'   => ['bg' => 'bg-rose-50', 'text' => 'text-rose-700', 'border' => 'border-rose-100/50', 'dot' => 'bg-rose-500', 'label' => 'Dibatalkan'],
                        ];
                        $sc = $statusConfig[$item->status_pesanan] ?? $statusConfig['pending'];
                    @endphp

                    <tr class="hover:bg-gray-50/60 transition-colors group">
                        <td class="px-6 py-4"><span class="text-sm font-semibold text-gray-900 whitespace-nowrap">#PO-{{ str_pad($item->id_pesanan, 3, '0', STR_PAD_LEFT) }}</span></td>
                        <td class="px-6 py-4"><span class="text-sm text-gray-600 whitespace-nowrap">{{ \Carbon\Carbon::parse($item->tanggal_pesanan)->format('d M Y') }}</span></td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-{{ $color }}-50 flex items-center justify-center border border-{{ $color }}-100 shrink-0 text-xs font-bold text-{{ $color }}-600">{{ $initials }}</div>
                                <span class="text-sm font-medium text-gray-900 whitespace-nowrap">{{ $item->user->nama }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4"><span class="text-sm text-gray-900 font-semibold whitespace-nowrap">Rp {{ number_format($item->total, 0, ',', '.') }}</span></td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $sc['bg'] }} {{ $sc['text'] }} border {{ $sc['border'] }} whitespace-nowrap">
                                <span class="w-1.5 h-1.5 rounded-full {{ $sc['dot'] }}"></span> {{ $sc['label'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end">
                                <button onclick="openModal({{ $item->id_pesanan }})" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition-colors" title="Lihat Detail">
                                    <iconify-icon icon="lucide:eye" class="text-[14px]"></iconify-icon> Lihat Detail
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-sm text-gray-500">Tidak ada data pesanan ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Footer -->
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50/50 flex flex-col sm:flex-row items-center justify-between gap-4 mt-auto">
            <span class="text-sm text-gray-500">Menampilkan <span class="font-medium text-gray-900">{{ $pesanan->firstItem() ?? 0 }}-{{ $pesanan->lastItem() ?? 0 }}</span> dari <span class="font-medium text-gray-900">{{ $pesanan->total() }}</span> pesanan</span>
            <div class="flex items-center gap-1.5">
                {{ $pesanan->links() }}
            </div>
        </div>
    </div>

    <!-- Modal Pop Up Detail & Update Pesanan -->
    <div id="pesananModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background Overlay -->
            <div class="fixed inset-0 bg-gray-500/75 transition-opacity" onclick="closeModal()"></div>

            <!-- Modal Panel -->
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold leading-6 text-gray-900" id="modal-title">Detail Pesanan</h3>
                        <button onclick="closeModal()" class="text-gray-400 hover:text-gray-500">
                            <iconify-icon icon="lucide:x" class="text-xl"></iconify-icon>
                        </button>
                    </div>

                    <div id="modalBody" class="space-y-4">
                        <!-- Disiikan via AJAX -->
                        <div class="flex justify-center py-8">
                            <iconify-icon icon="lucide:loader-2" class="animate-spin text-2xl text-gray-400"></iconify-icon>
                        </div>
                    </div>
                </div>

                <!-- Form Update Status -->
                <div class="bg-gray-50 px-4 py-3 sm:px-6 flex flex-col gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Update Status</label>
                        <select id="updateStatus" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2">
                            <option value="pending">Pending</option>
                            <option value="diproses">Diproses</option>
                            <option value="dikirim">Dikirim</option>
                            <option value="selesai">Selesai</option>
                            <option value="dibatalkan">Dibatalkan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Resi</label>
                        <input type="text" id="updateResi" placeholder="Masukkan nomor resi pengiriman" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2">
                    </div>
                    <button onclick="submitUpdate()" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2.5 bg-gray-900 text-base font-medium text-white hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 sm:text-sm transition-all">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Notifikasi Sukses -->
    <div id="toastNotif" class="fixed top-6 right-6 z-[60] hidden">
        <div class="bg-emerald-500 text-white px-5 py-3 rounded-xl shadow-lg flex items-center gap-2">
            <iconify-icon icon="lucide:check-circle" class="text-lg"></iconify-icon>
            <span id="toastMessage" class="text-sm font-medium">Berhasil memperbarui pesanan!</span>
        </div>
    </div>

    <script>
        let currentPesananId = null;

        function openModal(id) {
            currentPesananId = id;
            const modal = document.getElementById('pesananModal');
            const modalBody = document.getElementById('modalBody');
            
            modal.classList.remove('hidden');
            modalBody.innerHTML = `<div class="flex justify-center py-8"><iconify-icon icon="lucide:loader-2" class="animate-spin text-2xl text-gray-400"></iconify-icon></div>`;

            fetch(`{{ url('admin/pesanan') }}/${id}`)
                .then(res => res.json())
                .then(data => {
                    const statusLabels = {
                        'pending': 'Pending', 'diproses': 'Diproses', 'dikirim': 'Dikirim', 
                        'selesai': 'Selesai', 'dibatalkan': 'Dibatalkan'
                    };

                    // ✅ Konversi ke Number satu per satu, bukan setelah concatenation
                    const totalHarga = Number(data.total_harga || 0);
                    const ongkir = Number(data.ongkir || 0);
                    const totalBayar = totalHarga + ongkir;

                    modalBody.innerHTML = `
                        <div class="bg-gray-50 rounded-xl p-4 space-y-2 text-sm">
                            <div class="flex justify-between"><span class="text-gray-500">ID Pesanan</span><span class="font-semibold text-gray-900">#PO-${String(data.id_pesanan).padStart(3, '0')}</span></div>
                            <div class="flex justify-between"><span class="text-gray-500">Pelanggan</span><span class="font-semibold text-gray-900">${data.user.nama}</span></div>
                            <div class="flex justify-between"><span class="text-gray-500">Tanggal</span><span class="font-semibold text-gray-900">${new Date(data.tanggal_pesanan).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' })}</span></div>
                            <div class="flex justify-between"><span class="text-gray-500">Total Bayar</span><span class="font-semibold text-gray-900">Rp ${totalBayar.toLocaleString('id-ID')}</span></div>
                        </div>
                        <div class="space-y-2 text-sm">
                            <div class="font-semibold text-gray-700 mt-3">Alamat Pengiriman:</div>
                            <p class="text-gray-600 bg-white border rounded-xl p-3">${data.alamat_pengiriman}</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-4 space-y-2 text-sm">
                            <div class="flex justify-between"><span class="text-gray-500">Kurir</span><span class="font-semibold text-gray-900">${data.layanan_kurir ?? '-'}</span></div>
                            <div class="flex justify-between"><span class="text-gray-500">Ongkir</span><span class="font-semibold text-gray-900">Rp ${ongkir.toLocaleString('id-ID')}</span></div>
                            <div class="flex justify-between"><span class="text-gray-500">Status</span><span class="font-semibold text-gray-900">${statusLabels[data.status_pesanan]}</span></div>
                            <div class="flex justify-between"><span class="text-gray-500">No. Resi</span><span class="font-semibold text-gray-900">${data.nomor_resi ?? '-'}</span></div>
                        </div>
                    `;

                    document.getElementById('updateStatus').value = data.status_pesanan;
                    document.getElementById('updateResi').value = data.nomor_resi ?? '';
                });
        }
        function closeModal() {
            document.getElementById('pesananModal').classList.add('hidden');
        }

        function submitUpdate() {
            if(!currentPesananId) return;

            const status = document.getElementById('updateStatus').value;
            const nomor_resi = document.getElementById('updateResi').value;

            fetch(`{{ url('admin/pesanan') }}/${currentPesananId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ status_pesanan: status, nomor_resi: nomor_resi })
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    closeModal();
                    showToast(data.message);
                    setTimeout(() => window.location.reload(), 1000); // Reload setelah 1 detik
                }
            });
        }

        function showToast(message) {
            const toast = document.getElementById('toastNotif');
            document.getElementById('toastMessage').innerText = message;
            toast.classList.remove('hidden');
            setTimeout(() => toast.classList.add('hidden'), 3000);
        }
    </script>

@endsection