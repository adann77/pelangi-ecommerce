@extends('layouts.admin')

@section('pageTitle', 'Kategori — Pelangi Accessories Admin')

@section('nav-kategori', 'active')

@section('headerTitle', 'Kategori Produk')

@section('headerActions')
    
@endsection

@section('content')

<!-- CSRF Token untuk AJAX -->
<meta name="csrf-token" content="{{ csrf_token() }}">

@php
    $iconColors = [
        ['bg' => 'bg-purple-50',  'text' => 'text-purple-600',  'border' => 'border-purple-100/50'],
        ['bg' => 'bg-blue-50',    'text' => 'text-blue-600',    'border' => 'border-blue-100/50'],
        ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-600', 'border' => 'border-emerald-100/50'],
        ['bg' => 'bg-amber-50',   'text' => 'text-amber-600',   'border' => 'border-amber-100/50'],
        ['bg' => 'bg-rose-50',    'text' => 'text-rose-600',    'border' => 'border-rose-100/50'],
        ['bg' => 'bg-orange-50',  'text' => 'text-orange-600',  'border' => 'border-orange-100/50'],
        ['bg' => 'bg-cyan-50',    'text' => 'text-cyan-600',    'border' => 'border-cyan-100/50'],
        ['bg' => 'bg-indigo-50',  'text' => 'text-indigo-600',  'border' => 'border-indigo-100/50'],
    ];
@endphp
<button onclick="openAddModal()"
            class="flex items-center gap-2 px-4 py-2.5 rounded-xl bg-gray-900 text-white text-sm font-medium hover:bg-gray-800 transition-all shadow-sm active:scale-[0.98]">
        <iconify-icon icon="lucide:plus" class="text-lg"></iconify-icon>
        Tambah Kategori Baru
    </button>
<!-- Page Description -->
<p class="text-sm text-gray-500 mb-6">Organisasi dan kelola kategori untuk katalog produk.</p>

<!-- Search Bar -->
<form method="GET" action="{{ route('admin.kategori.index') }}" class="bg-white p-2 rounded-2xl border border-gray-200 shadow-[0_1px_2px_rgba(0,0,0,0.02)] mb-6 flex flex-col sm:flex-row gap-2">
    <div class="relative flex-1">
        <iconify-icon icon="lucide:search" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-lg"></iconify-icon>
        <input type="text"
               name="search"
               value="{{ request('search') }}"
               placeholder="Cari nama kategori..."
               class="w-full pl-11 pr-4 py-2.5 bg-transparent text-sm focus:outline-none placeholder:text-gray-400 text-gray-900">
    </div>
    @if(request()->filled('search'))
        <a href="{{ route('admin.kategori.index') }}"
           class="flex items-center gap-1.5 px-3 py-2 text-sm text-rose-600 hover:bg-rose-50 rounded-xl transition-colors whitespace-nowrap"
           title="Hapus pencarian">
            <iconify-icon icon="lucide:x" class="text-sm"></iconify-icon>
            Reset
        </a>
    @endif
</form>

<!-- Data Table -->
<div class="bg-white rounded-2xl border border-gray-200 shadow-[0_1px_2px_rgba(0,0,0,0.02)] flex-1 flex flex-col overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/80 border-b border-gray-200">
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap w-[80px]">No</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap w-[100px]">Ikon</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Nama Kategori</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Jumlah Produk</th>
                    <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right whitespace-nowrap w-[160px]">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($kategoris as $index => $kategori)
                    @php
                        $colorIndex = $index % count($iconColors);
                        $color      = $iconColors[$colorIndex];
                    @endphp
                    <tr class="hover:bg-gray-50/60 transition-colors group">
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-500 font-medium">{{ $kategoris->firstItem() + $index }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="w-10 h-10 rounded-lg {{ $color['bg'] }} flex items-center justify-center {{ $color['border'] }} shrink-0 overflow-hidden border">
                                @if($kategori->gambar_kategori)
                                    <img src="{{ $kategori->gambar_url }}" alt="{{ $kategori->nama_kategori }}" class="w-full h-full object-cover">
                                @else
                                    <iconify-icon icon="lucide:tag" class="{{ $color['text'] }} text-lg"></iconify-icon>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-medium text-gray-900">{{ $kategori->nama_kategori }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-medium {{ $kategori->produks_count > 0 ? 'text-gray-900' : 'text-gray-400' }}">
                                    {{ $kategori->produks_count }}
                                </span>
                                <span class="text-xs text-gray-400">produk</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-1">
                                <button onclick='openEditModal(this)'
                                        data-kategori='@json($kategori)'
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-blue-600 hover:bg-blue-50 transition-colors"
                                        title="Edit">
                                    <iconify-icon icon="lucide:edit-2" class="text-[14px]"></iconify-icon>
                                    Edit
                                </button>
                                <div class="w-px h-4 bg-gray-200"></div>
                                <button onclick='openDeleteModal(this)'
                                        data-kategori='@json($kategori)'
                                        data-count="{{ $kategori->produks_count }}"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-rose-600 hover:bg-rose-50 transition-colors"
                                        title="Hapus">
                                    <iconify-icon icon="lucide:trash-2" class="text-[14px]"></iconify-icon>
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-16 h-16 rounded-2xl bg-gray-50 flex items-center justify-center border border-gray-200">
                                    <iconify-icon icon="lucide:folder-open" class="text-2xl text-gray-300"></iconify-icon>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Belum ada kategori</p>
                                    <p class="text-xs text-gray-500 mt-1">Tambahkan kategori pertama Anda</p>
                                </div>
                                <button onclick="openAddModal()"
                                        class="mt-2 flex items-center gap-2 px-4 py-2 rounded-xl bg-gray-900 text-white text-sm font-medium hover:bg-gray-800 transition-all">
                                    <iconify-icon icon="lucide:plus" class="text-base"></iconify-icon>
                                    Tambah Kategori
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Table Footer -->
    @if($kategoris->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50/50 flex flex-col sm:flex-row items-center justify-between gap-4 mt-auto">
            <span class="text-sm text-gray-500">
                Menampilkan <span class="font-medium text-gray-900">{{ $kategoris->firstItem() ?? 0 }}–{{ $kategoris->lastItem() ?? 0 }}</span>
                dari <span class="font-medium text-gray-900">{{ $kategoris->total() }}</span> kategori
            </span>
            <div class="flex items-center gap-1.5">
                {{ $kategoris->appends(request()->query())->links('pagination::tailwind-simple') }}
            </div>
        </div>
    @else
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50/50 flex items-center justify-center mt-auto">
            <span class="text-sm text-gray-500">
                Menampilkan <span class="font-medium text-gray-900">{{ $kategoris->count() }}</span> kategori
            </span>
        </div>
    @endif
</div>

<!-- ═══════════════════════════════════════════════════════════════════
     MODAL: Tambah / Edit Kategori
     ═══════════════════════════════════════════════════════════════════ -->
<div id="modal-kategori" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity" onclick="closeKategoriModal()"></div>

    <!-- Modal Panel -->
    <div class="fixed inset-0 flex items-center justify-center p-4 pointer-events-none">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto pointer-events-auto transform transition-all">

            <!-- Header -->
            <div class="sticky top-0 z-10 bg-white px-6 py-4 border-b border-gray-200 flex items-center justify-between rounded-t-2xl">
                <h3 id="modal-kategori-title" class="text-lg font-semibold text-gray-900">Tambah Kategori Baru</h3>
                <button onclick="closeKategoriModal()" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                    <iconify-icon icon="lucide:x" class="text-lg text-gray-500"></iconify-icon>
                </button>
            </div>

            <!-- Form -->
            <form id="form-kategori" class="p-6 space-y-5" onsubmit="return false;" enctype="multipart/form-data">

                <!-- Hidden fields -->
                <input type="hidden" id="field-kategori-id" value="">
                <input type="hidden" id="field-method" value="POST">
                <!-- ★ Flag untuk hapus gambar — dikirim ke server saat user klik "Hapus Gambar" ★ -->
                <input type="hidden" id="field-remove-gambar" name="remove_gambar" value="0">

                <!-- Nama Kategori -->
                <div>
                    <label for="field-nama" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Nama Kategori <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="field-nama" name="nama_kategori" maxlength="100"
                           placeholder="Contoh: Anting, Kalung, Gelang..."
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-900 placeholder:text-gray-400 transition-colors">
                    <p id="error-nama_kategori" class="mt-1 text-xs text-rose-600 hidden"></p>
                </div>

                <!-- Gambar Kategori -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Gambar / Ikon Kategori</label>
                    <div id="upload-area"
                         class="relative border-2 border-dashed border-gray-200 rounded-xl p-6 text-center hover:border-gray-400 hover:bg-gray-50/50 transition-colors cursor-pointer"
                         onclick="document.getElementById('field-gambar').click()">
                        <input type="file" id="field-gambar" name="gambar_kategori"
                               accept="image/jpeg,image/png,image/jpg,image/webp"
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                               onchange="previewImage(this)">
                        <div id="upload-placeholder">
                            <iconify-icon icon="lucide:upload-cloud" class="text-3xl text-gray-300 mx-auto mb-2"></iconify-icon>
                            <p class="text-sm text-gray-500">Klik atau seret gambar ke sini</p>
                            <p class="text-xs text-gray-400 mt-1">JPEG, PNG, JPG, WebP — Maks 5MB</p>
                        </div>
                       
                    </div>
                    <center>
                    <div id="upload-preview" class="hidden">
                            <img id="image-preview" src="" alt="Preview" class="mx-auto max-h-32 rounded-lg object-contain">
                            <button type="button" onclick="event.stopPropagation(); removeImage()"
                                    class="mt-3 inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-rose-600 bg-rose-50 hover:bg-rose-100 border border-rose-200 rounded-lg transition-colors">
                                <iconify-icon icon="lucide:trash-2" class="text-sm"></iconify-icon>
                                Hapus Gambar
                            </button>
                        </div>
                    </center>
                     
                    <p id="error-gambar_kategori" class="mt-1 text-xs text-rose-600 hidden"></p>
                </div>

                <!-- Footer -->
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                    <button type="button" onclick="closeKategoriModal()"
                            class="px-4 py-2.5 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-100 border border-gray-200 transition-colors">
                        Batal
                    </button>
                    <button type="button" id="btn-submit-kategori" onclick="submitKategori()"
                            class="px-6 py-2.5 rounded-xl bg-gray-900 text-white text-sm font-medium hover:bg-gray-800 transition-all shadow-sm active:scale-[0.98] flex items-center gap-2">
                        <iconify-icon icon="lucide:check" class="text-base" id="btn-submit-icon"></iconify-icon>
                        <span id="btn-submit-text">Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════════════════
     MODAL: Konfirmasi Hapus
     ═══════════════════════════════════════════════════════════════════ -->
<div id="modal-delete" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity" onclick="closeDeleteModal()"></div>

    <!-- Modal Panel -->
    <div class="fixed inset-0 flex items-center justify-center p-4 pointer-events-none">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md pointer-events-auto transform transition-all">

            <div class="p-6 text-center">
                <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-rose-50 flex items-center justify-center border border-rose-100">
                    <iconify-icon icon="lucide:trash-2" class="text-2xl text-rose-500"></iconify-icon>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Hapus Kategori</h3>
                <p class="text-sm text-gray-500">
                    Apakah Anda yakin ingin menghapus kategori
                    <span id="delete-kategori-name" class="font-semibold text-gray-900"></span>?
                </p>
                <!-- Warning jika masih ada produk -->
                <div id="delete-warning" class="hidden mt-3 p-3 bg-amber-50 border border-amber-100 rounded-xl">
                    <div class="flex items-start gap-2">
                        <iconify-icon icon="lucide:alert-triangle" class="text-amber-500 text-lg shrink-0 mt-0.5"></iconify-icon>
                        <p id="delete-warning-text" class="text-xs text-amber-700 text-left"></p>
                    </div>
                </div>
                <p class="text-xs text-gray-400 mt-2">Tindakan ini tidak dapat dibatalkan.</p>
            </div>

            <div class="px-6 py-4 bg-gray-50/80 rounded-b-2xl border-t border-gray-200 flex gap-3 justify-end">
                <button onclick="closeDeleteModal()"
                        class="px-4 py-2.5 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-100 border border-gray-200 transition-colors">
                    Batal
                </button>
                <button id="btn-confirm-delete" onclick="confirmDelete()"
                        class="px-4 py-2.5 rounded-xl bg-rose-600 text-white text-sm font-medium hover:bg-rose-700 transition-all shadow-sm active:scale-[0.98] flex items-center gap-2">
                    <iconify-icon icon="lucide:trash-2" class="text-base"></iconify-icon>
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Toast Container -->
<div id="toast-container" class="fixed top-6 right-6 z-[200] flex flex-col gap-2 pointer-events-none"></div>

<!-- ═══════════════════════════════════════════════════════════════════
     JAVASCRIPT
     ═══════════════════════════════════════════════════════════════════ -->
<script>
(function () {
    const CSRF = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    /* ════════════════════════════════════════════════════
       State: melacak apakah user menghapus gambar saat edit
       ════════════════════════════════════════════════════ */
    let imageMarkedForRemoval = false;

    /* ── Toast Notification ── */
    window.showToast = function (message, type = 'success') {
        const container = document.getElementById('toast-container');
        const toast = document.createElement('div');

        const colors = type === 'success'
            ? 'bg-emerald-600 text-white'
            : 'bg-rose-600 text-white';

        const icon = type === 'success' ? 'lucide:check-circle-2' : 'lucide:alert-circle';

        toast.className = `pointer-events-auto flex items-center gap-2 px-4 py-3 rounded-xl shadow-lg text-sm font-medium ${colors} transform transition-all duration-300 translate-x-[120%]`;
        toast.innerHTML = `<iconify-icon icon="${icon}" class="text-lg shrink-0"></iconify-icon><span>${message}</span>`;
        container.appendChild(toast);

        requestAnimationFrame(() => {
            toast.classList.remove('translate-x-[120%]');
        });

        setTimeout(() => {
            toast.classList.add('translate-x-[120%]');
            setTimeout(() => toast.remove(), 300);
        }, 3500);
    };

    /* ── Clear validation errors ── */
    function clearErrors() {
        document.querySelectorAll('[id^="error-"]').forEach(el => {
            el.textContent = '';
            el.classList.add('hidden');
        });
        document.querySelectorAll('#form-kategori input, #form-kategori select, #form-kategori textarea').forEach(el => {
            el.classList.remove('border-rose-400');
        });
    }

    /* ── Show validation errors ── */
    function showErrors(errors) {
        clearErrors();
        Object.keys(errors).forEach(field => {
            const errorEl = document.getElementById(`error-${field}`);
            const inputEl = document.querySelector(`[name="${field}"]`);
            if (errorEl) {
                errorEl.textContent = errors[field][0];
                errorEl.classList.remove('hidden');
            }
            if (inputEl) {
                inputEl.classList.add('border-rose-400');
            }
        });
    }

    /* ════════════════════════════════════════════════════
       Image Preview & Remove
       ════════════════════════════════════════════════════ */

    window.previewImage = function (input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('image-preview').src = e.target.result;
                document.getElementById('upload-placeholder').classList.add('hidden');
                document.getElementById('upload-preview').classList.remove('hidden');
            };
            reader.readAsDataURL(input.files[0]);

            // ★ User upload gambar baru → reset flag hapus
            imageMarkedForRemoval = false;
            document.getElementById('field-remove-gambar').value = '0';
        }
    };

    window.removeImage = function () {
        // ★ Reset file input
        document.getElementById('field-gambar').value = '';

        // ★ Tampilkan placeholder, sembunyikan preview
        document.getElementById('image-preview').src = '';
        document.getElementById('upload-placeholder').classList.remove('hidden');
        document.getElementById('upload-preview').classList.add('hidden');

        // ★ TANDAI bahwa user ingin menghapus gambar lama dari server
        imageMarkedForRemoval = true;
        document.getElementById('field-remove-gambar').value = '1';
    };

    /* ════════════════════════════════════════════════════
       Modal: Tambah
       ════════════════════════════════════════════════════ */

    window.openAddModal = function () {
        clearErrors();

        document.getElementById('modal-kategori-title').textContent = 'Tambah Kategori Baru';
        document.getElementById('btn-submit-text').textContent = 'Simpan';
        document.getElementById('field-kategori-id').value = '';
        document.getElementById('field-method').value = 'POST';

        // Reset semua field
        document.getElementById('field-nama').value = '';
        document.getElementById('field-gambar').value = '';
        document.getElementById('image-preview').src = '';
        document.getElementById('upload-placeholder').classList.remove('hidden');
        document.getElementById('upload-preview').classList.add('hidden');

        // ★ Reset flag hapus gambar
        imageMarkedForRemoval = false;
        document.getElementById('field-remove-gambar').value = '0';

        document.getElementById('modal-kategori').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');

        setTimeout(() => document.getElementById('field-nama').focus(), 200);
    };

    /* ════════════════════════════════════════════════════
       Modal: Edit
       ════════════════════════════════════════════════════ */

    window.openEditModal = function (button) {
        clearErrors();

        const kategori = JSON.parse(button.dataset.kategori);

        document.getElementById('modal-kategori-title').textContent = 'Edit Kategori';
        document.getElementById('btn-submit-text').textContent = 'Perbarui';
        document.getElementById('field-kategori-id').value = kategori.id_kategori;
        document.getElementById('field-method').value = 'PUT';

        document.getElementById('field-nama').value = kategori.nama_kategori || '';

        // ★ Reset file input (user harus pilih file baru kalau mau ganti)
        document.getElementById('field-gambar').value = '';

        // ★ Reset flag hapus gambar
        imageMarkedForRemoval = false;
        document.getElementById('field-remove-gambar').value = '0';

        // Tampilkan gambar saat ini jika ada
        if (kategori.gambar_kategori) {
            document.getElementById('image-preview').src = '/storage/' + kategori.gambar_kategori;
            document.getElementById('upload-placeholder').classList.add('hidden');
            document.getElementById('upload-preview').classList.remove('hidden');
        } else {
            document.getElementById('image-preview').src = '';
            document.getElementById('upload-placeholder').classList.remove('hidden');
            document.getElementById('upload-preview').classList.add('hidden');
        }

        document.getElementById('modal-kategori').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');

        setTimeout(() => document.getElementById('field-nama').focus(), 200);
    };

    /* ════════════════════════════════════════════════════
       Modal: Close
       ════════════════════════════════════════════════════ */

    window.closeKategoriModal = function () {
        document.getElementById('modal-kategori').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        clearErrors();
    };

    /* ════════════════════════════════════════════════════
       Submit: Tambah / Edit
       ════════════════════════════════════════════════════ */

    window.submitKategori = function () {
        clearErrors();

        const kategoriId = document.getElementById('field-kategori-id').value;
        const method     = document.getElementById('field-method').value;

        const url = method === 'PUT'
            ? `/admin/kategori/${kategoriId}`
            : '/admin/kategori';

        const formData = new FormData(document.getElementById('form-kategori'));

        if (method === 'PUT') {
            formData.append('_method', 'PUT');
        }

        // ★ Pastikan flag remove_gambar ikut terkirim
        //    FormData otomatis ambil dari <input name="remove_gambar">,
        //    tapi kita pastikan nilainya sesuai state
        formData.set('remove_gambar', imageMarkedForRemoval ? '1' : '0');

        const btn     = document.getElementById('btn-submit-kategori');
        const btnText = document.getElementById('btn-submit-text');
        const origTxt = btnText.textContent;
        btnText.textContent = 'Menyimpan...';
        btn.disabled = true;
        btn.classList.add('opacity-60', 'cursor-not-allowed');

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': CSRF,
                'Accept': 'application/json',
            },
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                closeKategoriModal();
                showToast(data.message, 'success');
                setTimeout(() => location.reload(), 800);
            } else if (data.errors) {
                showErrors(data.errors);
            } else {
                showToast(data.message || 'Terjadi kesalahan', 'error');
            }
        })
        .catch(error => {
            showToast('Terjadi kesalahan jaringan', 'error');
            console.error(error);
        })
        .finally(() => {
            btnText.textContent = origTxt;
            btn.disabled = false;
            btn.classList.remove('opacity-60', 'cursor-not-allowed');
        });
    };

    /* ════════════════════════════════════════════════════
       Modal: Hapus Kategori
       ════════════════════════════════════════════════════ */

    window.openDeleteModal = function (button) {
        const kategori = JSON.parse(button.dataset.kategori);
        const count    = parseInt(button.dataset.count) || 0;

        document.getElementById('delete-kategori-name').textContent = kategori.nama_kategori;
        document.getElementById('btn-confirm-delete').dataset.kategoriId = kategori.id_kategori;

        // Tampilkan peringatan jika masih ada produk
        const warningEl = document.getElementById('delete-warning');
        if (count > 0) {
            document.getElementById('delete-warning-text').textContent =
                `Kategori ini masih memiliki ${count} produk. Pindahkan atau hapus produk terlebih dahulu sebelum menghapus kategori.`;
            warningEl.classList.remove('hidden');
            // Disable tombol hapus
            document.getElementById('btn-confirm-delete').classList.add('opacity-50', 'cursor-not-allowed');
            document.getElementById('btn-confirm-delete').disabled = true;
        } else {
            warningEl.classList.add('hidden');
            document.getElementById('btn-confirm-delete').classList.remove('opacity-50', 'cursor-not-allowed');
            document.getElementById('btn-confirm-delete').disabled = false;
        }

        document.getElementById('modal-delete').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    };

    window.closeDeleteModal = function () {
        document.getElementById('modal-delete').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    };

    window.confirmDelete = function () {
        const kategoriId = document.getElementById('btn-confirm-delete').dataset.kategoriId;

        // Jika tombol disabled (karena masih ada produk), jangan lakukan apa-apa
        if (document.getElementById('btn-confirm-delete').disabled) return;

        const btn  = document.getElementById('btn-confirm-delete');
        const orig = btn.innerHTML;
        btn.innerHTML = '<iconify-icon icon="lucide:loader-2" class="text-base animate-spin"></iconify-icon> Menghapus...';
        btn.disabled = true;
        btn.classList.add('opacity-60');

        fetch(`/admin/kategori/${kategoriId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': CSRF,
                'Accept': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                closeDeleteModal();
                showToast(data.message, 'success');
                setTimeout(() => location.reload(), 800);
            } else {
                showToast(data.message || 'Gagal menghapus kategori', 'error');
            }
        })
        .catch(error => {
            showToast('Terjadi kesalahan jaringan', 'error');
            console.error(error);
        })
        .finally(() => {
            btn.innerHTML = orig;
            btn.disabled = false;
            btn.classList.remove('opacity-60');
        });
    };

    /* ── Close modal with Escape key ── */
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            if (!document.getElementById('modal-delete').classList.contains('hidden')) {
                closeDeleteModal();
            }
            if (!document.getElementById('modal-kategori').classList.contains('hidden')) {
                closeKategoriModal();
            }
        }
    });

    /* ── Submit form on Enter key ── */
    document.getElementById('field-nama').addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            submitKategori();
        }
    });
})();
</script>

@endsection