@extends('layouts.admin')

@section('pageTitle', 'Produk — Pelangi Accessories Admin')

@section('nav-produk', 'active')

@section('headerTitle', 'Katalog Produk')

@section('headerActions')
    
@endsection

@section('content')
<button onclick="resetFormTambah(); openModal('modal-tambah')"
        class="flex items-center gap-2 px-4 py-2.5 rounded-xl bg-gray-900 text-white text-sm font-medium hover:bg-gray-800 transition-all shadow-sm active:scale-[0.98]">
        <iconify-icon icon="lucide:plus" class="text-lg"></iconify-icon>
        Tambah Produk Baru
    </button>
    {{-- ── Flash message ─────────────────────────────────────────────── --}}
    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="mb-5 flex items-center gap-3 px-4 py-3 bg-emerald-50 border border-emerald-200
                    text-emerald-700 text-sm rounded-xl shadow-sm">
            <iconify-icon icon="lucide:circle-check" class="text-emerald-500 text-lg shrink-0"></iconify-icon>
            {{ session('success') }}
        </div>
    @endif

    <!-- Page Description -->
    <p class="text-sm text-gray-500 mb-6">Kelola inventaris, harga, varian, dan galeri produk.</p>

    {{-- ── Search & Filter ────────────────────────────────────────────── --}}
    <form method="GET" action="{{ route('admin.produk.index') }}"
          class="bg-white p-2 rounded-2xl border border-gray-200 shadow-[0_1px_2px_rgba(0,0,0,0.02)]
                 mb-6 flex flex-col sm:flex-row gap-2">

        <div class="relative flex-1">
            <iconify-icon icon="lucide:search"
                class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-lg pointer-events-none">
            </iconify-icon>
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cari nama produk atau kategori..."
                class="w-full pl-11 pr-4 py-2.5 bg-transparent text-sm focus:outline-none
                       placeholder:text-gray-400 text-gray-900">
        </div>

        <div class="hidden sm:block w-px bg-gray-200 my-2"></div>

        <select name="id_kategori"
                class="px-4 py-2 text-sm text-gray-600 bg-transparent focus:outline-none
                       rounded-xl hover:bg-gray-50 transition-colors cursor-pointer">
            <option value="">Semua Kategori</option>
            @foreach ($kategoris as $kat)
                <option value="{{ $kat->id_kategori }}"
                    {{ request('id_kategori') == $kat->id_kategori ? 'selected' : '' }}>
                    {{ $kat->nama_kategori }}
                </option>
            @endforeach
        </select>

        <button type="submit"
                class="flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium
                       text-white bg-gray-800 hover:bg-gray-700 rounded-xl transition-colors">
            <iconify-icon icon="lucide:filter"></iconify-icon>
            Filter
        </button>
    </form>

    {{-- ── Data Table ──────────────────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl border border-gray-200 shadow-[0_1px_2px_rgba(0,0,0,0.02)]
                flex-1 flex flex-col overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/80 border-b border-gray-200">
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Nama Produk</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Kategori</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Harga</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Harga Reseller</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Stok</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($produks as $produk)
                        @php
                            $palette = ['purple','blue','emerald','amber','rose','indigo','teal','cyan','orange','pink'];
                            $color   = $palette[$produk->id_kategori % count($palette)];
                        @endphp
                        <tr class="hover:bg-gray-50/60 transition-colors group">

                            {{-- Nama --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-gray-50 flex items-center justify-center
                                                border border-gray-200 shrink-0 overflow-hidden">
                                        @if ($produk->gambar_produk)
                                            <img src="{{ asset('storage/' . $produk->gambar_produk) }}"
                                                 alt="{{ $produk->nama_produk }}"
                                                 class="w-full h-full object-cover">
                                        @else
                                            <iconify-icon icon="lucide:gem" class="text-gray-400"></iconify-icon>
                                        @endif
                                    </div>
                                    <span class="text-sm font-medium text-gray-900 line-clamp-1">
                                        {{ $produk->nama_produk }}
                                    </span>
                                </div>
                            </td>

                            {{-- Kategori --}}
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium
                                             bg-{{ $color }}-50 text-{{ $color }}-700 border border-{{ $color }}-100/50">
                                    {{ $produk->kategori->nama_kategori ?? '—' }}
                                </span>
                            </td>

                            {{-- Harga --}}
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-600 font-medium whitespace-nowrap">
                                    Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                </span>
                            </td>

                            {{-- Harga Reseller --}}
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-500 whitespace-nowrap">
                                    {{ $produk->harga_reseller
                                        ? 'Rp ' . number_format($produk->harga_reseller, 0, ',', '.')
                                        : '—' }}
                                </span>
                            </td>

                            {{-- Stok --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    @if ($produk->stok > 100)
                                        <div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div>
                                    @elseif ($produk->stok > 20)
                                        <div class="w-1.5 h-1.5 rounded-full bg-amber-500"></div>
                                    @else
                                        <div class="w-1.5 h-1.5 rounded-full bg-rose-500"></div>
                                    @endif
                                    <span class="text-sm font-medium text-gray-900">{{ $produk->stok }}</span>
                                </div>
                            </td>

                            {{-- Aksi --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-1
                                            opacity-0 group-hover:opacity-100 transition-opacity">

                                    <button onclick="openEditModal(this)"
                                    data-id="{{ $produk->id_produk }}"
                                    data-kategori="{{ $produk->id_kategori }}"
                                    data-nama="{{ $produk->nama_produk }}"
                                    data-deskripsi="{{ $produk->deskripsi ?? '' }}"
                                    data-harga="{{ $produk->harga }}"
                                    data-harga-reseller="{{ $produk->harga_reseller ?? '' }}"
                                    data-stok="{{ $produk->stok }}"
                                    data-gambar="{{ $produk->gambar_produk ?? '' }}"
                                    data-variants='@json($produk->varians->makeHidden(['gambar_varian_url']))'
                                    data-images='@json($produk->gambars)'
                                    class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                    title="Edit">
                                    <iconify-icon icon="lucide:edit-2" class="text-[16px]"></iconify-icon>
                                </button>

                                    {{-- Hapus --}}
                                    <button onclick="openDeleteModal({{ $produk->id_produk }},
                                                        '{{ addslashes($produk->nama_produk) }}')"
                                            class="p-2 text-gray-400 hover:text-rose-600 hover:bg-rose-50
                                                   rounded-lg transition-colors" title="Hapus">
                                        <iconify-icon icon="lucide:trash-2" class="text-[16px]"></iconify-icon>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center gap-3 text-gray-400">
                                    <iconify-icon icon="lucide:package-open" class="text-5xl"></iconify-icon>
                                    <p class="text-sm">Belum ada produk. Tambahkan produk pertama Anda!</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Footer --}}
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50/50
                    flex flex-col sm:flex-row items-center justify-between gap-4 mt-auto">
            <span class="text-sm text-gray-500">
                Menampilkan
                <span class="font-medium text-gray-900">{{ $produks->firstItem() }}–{{ $produks->lastItem() }}</span>
                dari
                <span class="font-medium text-gray-900">{{ $produks->total() }}</span> produk
            </span>
            <div class="flex items-center gap-1.5">
                {{-- Prev --}}
                @if ($produks->onFirstPage())
                    <button disabled
                        class="p-1.5 rounded-lg border border-gray-200 bg-white text-gray-300 cursor-not-allowed">
                        <iconify-icon icon="lucide:chevron-left" class="text-[18px]"></iconify-icon>
                    </button>
                @else
                    <a href="{{ $produks->previousPageUrl() }}"
                       class="p-1.5 rounded-lg border border-gray-200 bg-white text-gray-600
                              hover:text-gray-900 hover:bg-gray-50 transition-colors">
                        <iconify-icon icon="lucide:chevron-left" class="text-[18px]"></iconify-icon>
                    </a>
                @endif

                {{-- Page numbers --}}
                <div class="flex items-center gap-0.5 px-1">
                    @foreach ($produks->getUrlRange(1, $produks->lastPage()) as $page => $url)
                        @if ($page == $produks->currentPage())
                            <span class="w-8 h-8 flex items-center justify-center rounded-lg
                                         bg-gray-900 text-white text-sm font-medium">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}"
                               class="w-8 h-8 flex items-center justify-center rounded-lg
                                      text-gray-600 hover:bg-gray-100 text-sm font-medium transition-colors">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                </div>

                {{-- Next --}}
                @if ($produks->hasMorePages())
                    <a href="{{ $produks->nextPageUrl() }}"
                       class="p-1.5 rounded-lg border border-gray-200 bg-white text-gray-600
                              hover:text-gray-900 hover:bg-gray-50 transition-colors">
                        <iconify-icon icon="lucide:chevron-right" class="text-[18px]"></iconify-icon>
                    </a>
                @else
                    <button disabled
                        class="p-1.5 rounded-lg border border-gray-200 bg-white text-gray-300 cursor-not-allowed">
                        <iconify-icon icon="lucide:chevron-right" class="text-[18px]"></iconify-icon>
                    </button>
                @endif
            </div>
        </div>
    </div>


    {{-- ══════════════════════════════════════════════════════════════════
         MODAL — TAMBAH PRODUK
    ══════════════════════════════════════════════════════════════════ --}}
    <div id="modal-tambah"
         class="fixed inset-0 z-50 hidden items-center justify-center p-4"
         role="dialog" aria-modal="true" aria-labelledby="modal-tambah-title">

        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"
             onclick="closeModal('modal-tambah')"></div>

        <div class="relative w-full max-w-2xl bg-white rounded-2xl shadow-xl
                    flex flex-col max-h-[90vh] overflow-hidden">

            <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-gray-900 flex items-center justify-center">
                        <iconify-icon icon="lucide:plus" class="text-white text-lg"></iconify-icon>
                    </div>
                    <div>
                        <h2 id="modal-tambah-title" class="text-base font-semibold text-gray-900">Tambah Produk Baru</h2>
                        <p class="text-xs text-gray-400 mt-0.5">Lengkapi detail produk, varian, dan foto</p>
                    </div>
                </div>
                <button onclick="closeModal('modal-tambah')"
                        class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                    <iconify-icon icon="lucide:x" class="text-lg"></iconify-icon>
                </button>
            </div>

            <div class="overflow-y-auto flex-1">
                <form id="form-tambah"
                      action="{{ route('admin.produk.store') }}"
                      method="POST"
                      enctype="multipart/form-data"
                      class="px-6 py-5 space-y-5">
                    @csrf

                    {{-- Info Dasar --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-medium text-gray-700 mb-1.5">
                                Nama Produk <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="nama_produk" required maxlength="100"
                                   placeholder="Contoh: Anting Mutiara Elegan"
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm
                                          focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-400
                                          placeholder:text-gray-400 transition">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1.5">
                                Kategori <span class="text-rose-500">*</span>
                            </label>
                            <select name="id_kategori" required
                                    class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm
                                           focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-400
                                           bg-white transition cursor-pointer">
                                <option value="" disabled selected>Pilih kategori…</option>
                                @foreach ($kategoris as $kat)
                                    <option value="{{ $kat->id_kategori }}">{{ $kat->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                             <label class="block text-xs font-medium text-gray-700 mb-1.5">
                                Stok Awal <span class="text-rose-500">*</span>
                            </label>
                            <input type="number" name="stok" required min="0" value="0"
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm
                                          focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-400
                                          transition">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1.5">
                                Harga (Rp) <span class="text-rose-500">*</span>
                            </label>
                            {{-- ✅ FIX: Tambahkan id="tambah-harga" untuk akses JS --}}
                            <input type="number" id="tambah-harga" name="harga" required min="0" step="100"
                                   placeholder="75000"
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm
                                          focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-400
                                          placeholder:text-gray-400 transition">
                        </div>
                        <div>
                            {{-- ✅ FIX: Label diupdate untuk menunjukkan otomatis 10% diskon --}}
                            <label class="block text-xs font-medium text-gray-700 mb-1.5">
                                Harga Reseller (Rp)
                                <span class="text-gray-400 font-normal ml-1">— otomatis −10%</span>
                            </label>
                            {{-- ✅ FIX: Tambahkan id="tambah-harga-reseller" untuk akses JS --}}
                            <input type="number" id="tambah-harga-reseller" name="harga_reseller" min="0" step="100"
                                   placeholder="Otomatis dari harga × 90%"
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm
                                          focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-400
                                          placeholder:text-gray-400 transition">
                            {{-- ✅ FIX: Hint kecil --}}
                            <p id="tambah-harga-reseller-hint" class="text-[11px] text-gray-400 mt-1 hidden">
                                Diskon 10% dari harga: <span id="tambah-reseller-calc"></span>
                            </p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-medium text-gray-700 mb-1.5">Deskripsi</label>
                            <textarea name="deskripsi" rows="2"
                                      placeholder="Deskripsi singkat produk (opsional)…"
                                      class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm
                                             focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-400
                                             placeholder:text-gray-400 resize-none transition"></textarea>
                        </div>
                    </div>

                    <hr class="border-gray-100">

                    {{-- Varian --}}
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label class="text-xs font-semibold text-gray-700">Varian Produk</label>
                            <button type="button" onclick="addVariantRow('tambah')" 
                                    class="text-xs font-medium text-blue-600 hover:text-blue-700 flex items-center gap-1">
                                <iconify-icon icon="lucide:plus-circle" class="text-sm"></iconify-icon>
                                Tambah Varian
                            </button>
                        </div>
                        <div id="tambah-varians-container" class="space-y-3">
                        </div>
                    </div>

                    <hr class="border-gray-100">

                    {{-- Foto Utama --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">
                            Foto Utama Produk <span class="text-rose-500">*</span>
                        </label>
                        <p class="text-xs text-gray-400 mb-3">
                            Pilih salah satu dari gambar varian yang sudah Anda tambahkan di atas.
                        </p>

                        <div id="tambah-foto-utama-empty"
                             class="flex flex-col items-center justify-center gap-2 py-8 rounded-xl
                                    border border-dashed border-gray-200 bg-gray-50 text-gray-400">
                            <iconify-icon icon="lucide:image-off" class="text-3xl"></iconify-icon>
                            <p class="text-xs">Belum ada gambar varian. Tambahkan varian beserta fotonya terlebih dahulu.</p>
                        </div>

                        <div id="tambah-foto-utama-grid"
                             class="hidden grid grid-cols-4 sm:grid-cols-6 gap-3">
                        </div>

                        <input type="hidden" name="gambar_utama_index" id="tambah-gambar-utama-index" value="">
                    </div>

                    <hr class="border-gray-100">

                    {{-- Galeri Tambahan --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-2">Galeri Foto Tambahan</label>
                        <label class="flex items-center justify-center gap-3 px-4 py-4 rounded-xl border border-dashed
                                      border-blue-200 cursor-pointer hover:border-blue-400 hover:bg-blue-50/50
                                      transition group">
                            <iconify-icon icon="lucide:images"
                                class="text-blue-400 text-xl group-hover:text-blue-600 transition"></iconify-icon>
                            <p class="text-sm font-medium text-blue-600 group-hover:text-blue-700">Pilih Banyak Foto</p>
                            <input type="file" name="gambars[]" accept="image/*" multiple class="hidden"
                                   onchange="updateMultiFileLabel(this, 'tambah-multi-label')">
                        </label>
                        <p id="tambah-multi-label" class="text-xs text-gray-400 mt-1"></p>
                    </div>

                </form>
            </div>

            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50 flex justify-end gap-2">
                <button type="button" onclick="closeModal('modal-tambah')"
                        class="px-4 py-2.5 rounded-xl text-sm font-medium text-gray-600
                               hover:bg-gray-100 transition-colors">
                    Batal
                </button>
                <button type="submit" form="form-tambah"
                        class="px-5 py-2.5 rounded-xl bg-gray-900 text-white text-sm font-medium
                               hover:bg-gray-800 transition-all active:scale-[0.98] shadow-sm">
                    Simpan Produk
                </button>
            </div>
        </div>
    </div>


    {{-- ══════════════════════════════════════════════════════════════════
         MODAL — EDIT PRODUK
    ══════════════════════════════════════════════════════════════════ --}}
    <div id="modal-edit"
         class="fixed inset-0 z-50 hidden items-center justify-center p-4"
         role="dialog" aria-modal="true" aria-labelledby="modal-edit-title">

        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"
             onclick="closeModal('modal-edit')"></div>

        <div class="relative w-full max-w-2xl bg-white rounded-2xl shadow-xl
                    flex flex-col max-h-[90vh] overflow-hidden">

            <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-blue-600 flex items-center justify-center">
                        <iconify-icon icon="lucide:edit-2" class="text-white"></iconify-icon>
                    </div>
                    <div>
                        <h2 id="modal-edit-title" class="text-base font-semibold text-gray-900">Edit Produk</h2>
                        <p class="text-xs text-gray-400 mt-0.5">Perbarui informasi, varian, dan foto</p>
                    </div>
                </div>
                <button onclick="closeModal('modal-edit')"
                        class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                    <iconify-icon icon="lucide:x" class="text-lg"></iconify-icon>
                </button>
            </div>

            <div class="overflow-y-auto flex-1">
                <form id="form-edit"
                      action=""
                      method="POST"
                      enctype="multipart/form-data"
                      class="px-6 py-5 space-y-5">
                    @csrf
                    @method('PUT')

                    {{-- Info Dasar --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-medium text-gray-700 mb-1.5">
                                Nama Produk <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" id="edit-nama" name="nama_produk" required maxlength="100"
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm
                                          focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400
                                          transition">
                        </div>
                         <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1.5">
                                Kategori <span class="text-rose-500">*</span>
                            </label>
                            <select id="edit-kategori" name="id_kategori" required
                                    class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm
                                           focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400
                                           bg-white transition cursor-pointer">
                                @foreach ($kategoris as $kat)
                                    <option value="{{ $kat->id_kategori }}">{{ $kat->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1.5">
                                Stok <span class="text-rose-500">*</span>
                            </label>
                            <input type="number" id="edit-stok" name="stok" required min="0"
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm
                                          focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400
                                          transition">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1.5">
                                Harga (Rp) <span class="text-rose-500">*</span>
                            </label>
                            <input type="number" id="edit-harga" name="harga" required min="0" step="100"
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm
                                          focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400
                                          transition">
                        </div>
                        <div>
                            {{-- ✅ FIX: Label diupdate untuk menunjukkan otomatis 10% diskon --}}
                            <label class="block text-xs font-medium text-gray-700 mb-1.5">
                                Harga Reseller (Rp)
                                <span class="text-gray-400 font-normal ml-1">— otomatis −10%</span>
                            </label>
                            <input type="number" id="edit-harga-reseller" name="harga_reseller" min="0" step="100"
                                   placeholder="Otomatis dari harga × 90%"
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm
                                          focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400
                                          placeholder:text-gray-400 transition">
                            {{-- ✅ FIX: Hint kecil --}}
                            <p id="edit-harga-reseller-hint" class="text-[11px] text-gray-400 mt-1 hidden">
                                Diskon 10% dari harga: <span id="edit-reseller-calc"></span>
                            </p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-medium text-gray-700 mb-1.5">Deskripsi</label>
                            <textarea id="edit-deskripsi" name="deskripsi" rows="2"
                                      placeholder="Deskripsi singkat produk (opsional)…"
                                      class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm
                                             focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400
                                             placeholder:text-gray-400 resize-none transition"></textarea>
                        </div>
                    </div>

                    <hr class="border-gray-100">

                    {{-- Edit Varian --}}
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label class="text-xs font-semibold text-gray-700">Daftar Varian</label>
                            <button type="button" onclick="addVariantRow('edit')" 
                                    class="text-xs font-medium text-blue-600 hover:text-blue-700 flex items-center gap-1">
                                <iconify-icon icon="lucide:plus-circle" class="text-sm"></iconify-icon>
                                Tambah Varian Baru
                            </button>
                        </div>
                        
                        <div id="edit-existing-varians" class="space-y-2 mb-3">
                        </div>

                        <div id="edit-new-varians-container" class="space-y-3 pt-3 border-t border-gray-100 border-dashed">
                        </div>
                    </div>

                    <hr class="border-gray-100">

                    {{-- Foto Utama (Edit) --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">
                            Foto Utama Produk
                        </label>
                        <p class="text-xs text-gray-400 mb-3">
                            Pilih dari gambar varian di bawah, atau biarkan kosong untuk mempertahankan foto saat ini.
                        </p>

                        <div class="flex items-center gap-3 mb-4 p-3 rounded-xl bg-blue-50 border border-blue-100">
                            <img id="edit-current-main-img"
                                 src="" alt="Foto Utama Saat Ini"
                                 class="w-14 h-14 rounded-lg object-cover border border-blue-200 bg-white shrink-0">
                            <div>
                                <p class="text-xs font-medium text-blue-700">Foto Utama Saat Ini</p>
                                <p class="text-xs text-blue-500 mt-0.5">Klik gambar varian di bawah untuk mengganti.</p>
                            </div>
                        </div>

                        <div id="edit-foto-utama-empty"
                             class="hidden flex-col items-center justify-center gap-2 py-6 rounded-xl
                                    border border-dashed border-gray-200 bg-gray-50 text-gray-400">
                            <iconify-icon icon="lucide:image-off" class="text-2xl"></iconify-icon>
                            <p class="text-xs">Tidak ada gambar varian tersedia.</p>
                        </div>

                        <div id="edit-foto-utama-grid"
                             class="grid grid-cols-4 sm:grid-cols-6 gap-3">
                        </div>

                        <input type="hidden" name="gambar_utama_path" id="edit-gambar-utama-path" value="">
                    </div>

                    <hr class="border-gray-100">

                    {{-- Edit Galeri Tambahan --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-2">Galeri Foto Tambahan</label>

                        <div id="edit-existing-gambars" class="grid grid-cols-4 gap-3 mb-3">
                        </div>

                        <label class="flex items-center justify-center gap-2 px-4 py-3 rounded-xl border border-dashed
                                    border-blue-200 cursor-pointer hover:border-blue-400 hover:bg-blue-50/50
                                    transition group">
                            <iconify-icon icon="lucide:images"
                                class="text-blue-400 text-lg group-hover:text-blue-600 transition"></iconify-icon>
                            <span class="text-sm font-medium text-blue-600 group-hover:text-blue-700">Tambah Foto Baru</span>
                            <input type="file" name="new_gambars[]" accept="image/*" multiple class="hidden"
                                onchange="updateMultiFileLabel(this, 'edit-multi-label')">
                        </label>
                        <p id="edit-multi-label" class="text-xs text-gray-400 mt-1"></p>
                    </div>

                </form>
            </div>

            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50 flex justify-end gap-2">
                <button type="button" onclick="closeModal('modal-edit')"
                        class="px-4 py-2.5 rounded-xl text-sm font-medium text-gray-600
                               hover:bg-gray-100 transition-colors">
                    Batal
                </button>
                <button type="submit" form="form-edit"
                        class="px-5 py-2.5 rounded-xl bg-blue-600 text-white text-sm font-medium
                               hover:bg-blue-700 transition-all active:scale-[0.98] shadow-sm">
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </div>


    {{-- ══════════════════════════════════════════════════════════════════
         MODAL — HAPUS PRODUK
    ══════════════════════════════════════════════════════════════════ --}}
    <div id="modal-hapus"
         class="fixed inset-0 z-50 hidden items-center justify-center p-4"
         role="dialog" aria-modal="true" aria-labelledby="modal-hapus-title">

        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"
             onclick="closeModal('modal-hapus')"></div>

        <div class="relative w-full max-w-sm bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="h-1 bg-rose-500"></div>
            <div class="px-6 pt-6 pb-2">
                <div class="flex items-start gap-4">
                    <div class="w-11 h-11 rounded-full bg-rose-50 flex items-center justify-center shrink-0">
                        <iconify-icon icon="lucide:trash-2" class="text-rose-500 text-xl"></iconify-icon>
                    </div>
                    <div>
                        <h2 id="modal-hapus-title" class="text-base font-semibold text-gray-900">
                            Hapus Produk?
                        </h2>
                        <p class="text-sm text-gray-500 mt-1">
                            Produk <span id="hapus-nama" class="font-semibold text-gray-800"></span>
                            akan dihapus permanen.
                        </p>
                    </div>
                </div>
            </div>
            <div class="px-6 py-5 flex justify-end gap-2">
                <button type="button" onclick="closeModal('modal-hapus')"
                        class="px-4 py-2.5 rounded-xl text-sm font-medium text-gray-600
                               hover:bg-gray-100 transition-colors">
                    Batal
                </button>
                <form id="form-hapus" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="px-5 py-2.5 rounded-xl bg-rose-600 text-white text-sm font-medium
                                   hover:bg-rose-700 transition-all active:scale-[0.98] shadow-sm">
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>


    {{-- ══════════════════════════════════════════════════════════════════
         JAVASCRIPT
    ══════════════════════════════════════════════════════════════════ --}}
    @push('scripts')
    <script>
        let variantIndex = 0;

        /* ── Helpers Modal ── */
        function openModal(id) {
            const modal = document.getElementById(id);
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') {
                ['modal-tambah', 'modal-edit', 'modal-hapus'].forEach(closeModal);
            }
        });

        function updateMultiFileLabel(input, labelId) {
            const count = input.files.length;
            const label = document.getElementById(labelId);
            label.textContent = count > 0 ? `${count} file dipilih` : '';
        }

        /* ═══════════════════════════════════════════════════════════════
        ✅ FIX: HARGA RESELLER OTOMATIS — KURANGI 10% DARI HARGA
        ═══════════════════════════════════════════════════════════════
        Ketika input Harga berubah, field Harga Reseller otomatis
        diisi dengan harga × 90% (diskon 10%). User masih bisa
        mengubah manual setelahnya.
        ═══════════════════════════════════════════════════════════════ */

        function formatRupiah(angka) {
            if (!angka || isNaN(angka)) return 'Rp 0';
            return 'Rp ' + Number(angka).toLocaleString('id-ID');
        }

        // ── Form TAMBAH ──
        const tambahHargaInput = document.getElementById('tambah-harga');
        const tambahResellerInput = document.getElementById('tambah-harga-reseller');
        const tambahHint = document.getElementById('tambah-harga-reseller-hint');
        const tambahCalcSpan = document.getElementById('tambah-reseller-calc');

        if (tambahHargaInput) {
            tambahHargaInput.addEventListener('input', function () {
                const harga = parseFloat(this.value);
                if (harga && harga > 0) {
                    const reseller = Math.round(harga * 0.9);
                    tambahResellerInput.value = reseller;
                    // Tampilkan hint
                    if (tambahHint && tambahCalcSpan) {
                        tambahCalcSpan.textContent = formatRupiah(reseller);
                        tambahHint.classList.remove('hidden');
                    }
                } else {
                    tambahResellerInput.value = '';
                    if (tambahHint) tambahHint.classList.add('hidden');
                }
            });
        }

        // ── Form EDIT ──
        const editHargaInput = document.getElementById('edit-harga');
        const editResellerInput = document.getElementById('edit-harga-reseller');
        const editHint = document.getElementById('edit-harga-reseller-hint');
        const editCalcSpan = document.getElementById('edit-reseller-calc');

        if (editHargaInput) {
            editHargaInput.addEventListener('input', function () {
                const harga = parseFloat(this.value);
                if (harga && harga > 0) {
                    const reseller = Math.round(harga * 0.9);
                    editResellerInput.value = reseller;
                    if (editHint && editCalcSpan) {
                        editCalcSpan.textContent = formatRupiah(reseller);
                        editHint.classList.remove('hidden');
                    }
                } else {
                    editResellerInput.value = '';
                    if (editHint) editHint.classList.add('hidden');
                }
            });
        }

        /* ═══════════════════════════════════════════════════════════════
        FOTO UTAMA PICKER — FORM TAMBAH
        ═══════════════════════════════════════════════════════════════ */
        function refreshTambahFotoUtama() {
            const grid    = document.getElementById('tambah-foto-utama-grid');
            const empty   = document.getElementById('tambah-foto-utama-empty');
            const hidden  = document.getElementById('tambah-gambar-utama-index');

            const varianContainer = document.getElementById('tambah-varians-container');
            const previews = varianContainer.querySelectorAll('img.varian-thumb');

            if (previews.length === 0) {
                grid.classList.add('hidden');
                empty.classList.remove('hidden');
                empty.classList.add('flex');
                hidden.value = '';
                return;
            }

            grid.classList.remove('hidden');
            empty.classList.add('hidden');
            empty.classList.remove('flex');
            grid.innerHTML = '';

            const selectedFormIndex = hidden.value;

            previews.forEach((img, displayIdx) => {
                const formIndex = img.id.replace('varian-thumb-preview-', '');
                const isSelected = formIndex === String(selectedFormIndex);

                const card = document.createElement('button');
                card.type = 'button';
                card.dataset.formIndex = formIndex;
                card.className = [
                    'relative rounded-xl overflow-hidden aspect-square border-2 transition-all',
                    isSelected
                        ? 'border-gray-900 ring-2 ring-gray-900/20 shadow-md scale-[1.03]'
                        : 'border-transparent hover:border-gray-300',
                ].join(' ');
                card.innerHTML = `
                    <img src="${img.src}" class="w-full h-full object-cover">
                    ${isSelected ? `
                    <span class="absolute top-1 right-1 w-5 h-5 bg-gray-900 rounded-full flex items-center justify-center shadow">
                        <iconify-icon icon="lucide:check" class="text-white text-[10px]"></iconify-icon>
                    </span>` : ''}
                    <span class="absolute bottom-0 left-0 right-0 bg-black/30 text-white text-[9px] text-center py-0.5 truncate px-1">
                        Varian ${displayIdx + 1}
                    </span>
                `;
                card.addEventListener('click', () => {
                    hidden.value = formIndex;
                    refreshTambahFotoUtama();
                });
                grid.appendChild(card);
            });
        }

        /* ═══════════════════════════════════════════════════════════════
        FOTO UTAMA PICKER — FORM EDIT
        ═══════════════════════════════════════════════════════════════ */
        function renderEditFotoUtama(variants, currentGambar) {
            const grid   = document.getElementById('edit-foto-utama-grid');
            const empty  = document.getElementById('edit-foto-utama-empty');
            const hidden = document.getElementById('edit-gambar-utama-path');

            const varianBergambar = (variants || []).filter(v => v.gambar_varian);

            if (varianBergambar.length === 0) {
                grid.innerHTML = '';
                grid.classList.add('hidden');
                empty.classList.remove('hidden');
                empty.classList.add('flex');
                hidden.value = currentGambar || '';
                return;
            }

            grid.classList.remove('hidden');
            empty.classList.add('hidden');
            empty.classList.remove('flex');
            grid.innerHTML = '';

            varianBergambar.forEach((v, idx) => {
                const path       = v.gambar_varian;
                const imgSrc     = '/storage/' + path;
                const isSelected = (path === hidden.value) || (idx === 0 && !hidden.value && path === currentGambar);

                if (isSelected && !hidden.value) {
                    hidden.value = path;
                }

                const card = document.createElement('button');
                card.type = 'button';
                card.dataset.path = path;
                card.className = [
                    'relative rounded-xl overflow-hidden aspect-square border-2 transition-all',
                    isSelected
                        ? 'border-blue-600 ring-2 ring-blue-500/20 shadow-md scale-[1.03]'
                        : 'border-transparent hover:border-blue-300',
                ].join(' ');
                card.title = v.nama_varian || ('Varian ' + (idx + 1));
                card.innerHTML = `
                    <img src="${imgSrc}" class="w-full h-full object-cover">
                    ${isSelected ? `
                    <span class="absolute top-1 right-1 w-5 h-5 bg-blue-600 rounded-full flex items-center justify-center shadow">
                        <iconify-icon icon="lucide:check" class="text-white text-[10px]"></iconify-icon>
                    </span>` : ''}
                    <span class="absolute bottom-0 left-0 right-0 bg-black/30 text-white text-[9px] text-center py-0.5 truncate px-1">
                        ${v.nama_varian || ('Varian ' + (idx + 1))}
                    </span>
                `;
                card.addEventListener('click', () => {
                    hidden.value = path;
                    document.getElementById('edit-current-main-img').src = imgSrc;
                    renderEditFotoUtama(variants, currentGambar);
                });
                grid.appendChild(card);
            });
        }

        /* ─── Variant Management ─── */
        function addVariantRow(modalType) {
            variantIndex++;
            const containerId = modalType === 'tambah' 
                ? 'tambah-varians-container' 
                : 'edit-new-varians-container';
            const namePrefix = modalType === 'tambah' ? 'varians' : 'new_varians';
            
            const html = `
                <div id="varian-row-${variantIndex}" class="p-3 rounded-lg border border-gray-200 bg-gray-50 flex flex-col sm:flex-row gap-3 items-start sm:items-center relative group">
                    <button type="button" onclick="removeVariantRow(${variantIndex}, '${modalType}')" class="absolute -top-2 -right-2 p-1 bg-rose-100 text-rose-600 rounded-full hover:bg-rose-200 shadow-sm">
                        <iconify-icon icon="lucide:x" class="text-xs"></iconify-icon>
                    </button>
                    
                    <div class="flex-1 w-full">
                        <input type="text" name="${namePrefix}[${variantIndex}][nama_varian]" placeholder="Nama Varian (cth: Merah, XL)" 
                            class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm focus:outline-none focus:border-gray-500">
                    </div>
                    
                    <div class="w-full sm:w-24">
                        <input type="number" name="${namePrefix}[${variantIndex}][stok_varian]" placeholder="Stok" min="0"
                            class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm focus:outline-none focus:border-gray-500">
                    </div>

                    <div class="w-full sm:w-auto flex items-center gap-2">
                        <label class="flex items-center justify-center w-10 h-10 rounded-lg border border-dashed border-gray-300 cursor-pointer hover:bg-white hover:border-gray-400 transition bg-white shrink-0" title="Pilih gambar varian">
                            <iconify-icon icon="lucide:image" class="text-gray-400" id="varian-icon-${variantIndex}"></iconify-icon>
                            <input type="file" name="${namePrefix}[${variantIndex}][gambar_varian]" accept="image/*" class="hidden"
                                data-row="${variantIndex}"
                                onchange="onVarianImageChange(this, ${variantIndex})">
                        </label>
                        <img id="varian-thumb-preview-${variantIndex}" 
                            src="" alt="" 
                            class="hidden varian-thumb w-10 h-10 rounded-lg object-cover border border-gray-200">
                    </div>
                </div>
            `;
            document.getElementById(containerId).insertAdjacentHTML('beforeend', html);
        }

        function removeVariantRow(id, modalType) {
            const row = document.getElementById(`varian-row-${id}`);
            if (row) row.remove();
            if (modalType === 'tambah') {
                refreshTambahFotoUtama();
            }
        }

        function onVarianImageChange(input, rowId) {
            const iconEl   = document.getElementById(`varian-icon-${rowId}`);
            const thumbEl  = document.getElementById(`varian-thumb-preview-${rowId}`);

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    thumbEl.src = e.target.result;
                    thumbEl.classList.remove('hidden');
                    thumbEl.classList.add('varian-thumb');
                    if (iconEl) iconEl.setAttribute('icon', 'lucide:check');
                    refreshTambahFotoUtama();
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                thumbEl.src = '';
                thumbEl.classList.add('hidden');
                if (iconEl) iconEl.setAttribute('icon', 'lucide:image');
                refreshTambahFotoUtama();
            }
        }

        /* ─── Open Edit Modal & Populate Data ─── */
        function openEditModal(btn) {
            try {
                var id             = btn.getAttribute('data-id');
                var idKategori     = btn.getAttribute('data-kategori');
                var nama           = btn.getAttribute('data-nama');
                var deskripsi      = btn.getAttribute('data-deskripsi');
                var harga          = btn.getAttribute('data-harga');
                var hargaReseller  = btn.getAttribute('data-harga-reseller');
                var stok           = btn.getAttribute('data-stok');
                var gambarProduk   = btn.getAttribute('data-gambar');

                var variants = [];
                var images   = [];

                var variantsAttr = btn.getAttribute('data-variants');
                var imagesAttr   = btn.getAttribute('data-images');

                if (variantsAttr && variantsAttr.trim() !== '') {
                    variants = JSON.parse(variantsAttr);
                }
                if (imagesAttr && imagesAttr.trim() !== '') {
                    images = JSON.parse(imagesAttr);
                }

                var baseUrl = '{{ url("admin/produk") }}';
                document.getElementById('form-edit').action = baseUrl + '/' + id;

                document.getElementById('edit-nama').value            = nama;
                document.getElementById('edit-deskripsi').value       = deskripsi;
                document.getElementById('edit-harga').value           = harga;
                document.getElementById('edit-harga-reseller').value  = hargaReseller;
                document.getElementById('edit-stok').value            = stok;

                // ✅ FIX: Tampilkan hint harga reseller saat edit modal terbuka
                if (editHint && editCalcSpan && harga && parseFloat(harga) > 0) {
                    editCalcSpan.textContent = formatRupiah(Math.round(parseFloat(harga) * 0.9));
                    editHint.classList.remove('hidden');
                }

                var selKat = document.getElementById('edit-kategori');
                for (var opt of selKat.options) {
                    opt.selected = (opt.value == idKategori);
                }

                var mainImg = document.getElementById('edit-current-main-img');
                if (gambarProduk) {
                    mainImg.src = '/storage/' + gambarProduk;
                    mainImg.classList.remove('hidden');
                } else {
                    mainImg.src = '';
                    mainImg.classList.add('hidden');
                }

                document.getElementById('edit-gambar-utama-path').value = gambarProduk || '';

                renderEditFotoUtama(variants, gambarProduk);

                // Render Varian Existing
                var varContainer = document.getElementById('edit-existing-varians');
                varContainer.innerHTML = '';
                if (variants && variants.length > 0) {
                    variants.forEach(function(v) {
                        var imgHtml = v.gambar_varian
                            ? '<img src="/storage/' + v.gambar_varian + '" class="w-8 h-8 rounded object-cover border border-gray-200">'
                            : '<div class="w-8 h-8 rounded bg-gray-100 flex items-center justify-center text-gray-400"><iconify-icon icon="lucide:image"></iconify-icon></div>';

                        var variantId = v.id || '';

                        varContainer.innerHTML +=
                            '<div class="flex items-center justify-between p-2 rounded-lg bg-gray-50 border border-gray-200">' +
                                '<div class="flex items-center gap-3">' +
                                    imgHtml +
                                    '<div>' +
                                        '<p class="text-sm font-medium text-gray-700">' + (v.nama_varian || '') + '</p>' +
                                        '<p class="text-xs text-gray-500">Stok: ' + (v.stok_varian || 0) + '</p>' +
                                    '</div>' +
                                '</div>' +
                                '<label class="flex items-center gap-2 cursor-pointer select-none">' +
                                    '<input type="checkbox" name="delete_varians[]" value="' + variantId + '" class="rounded border-gray-300 text-rose-600 focus:ring-rose-500">' +
                                    '<span class="text-xs text-rose-600">Hapus</span>' +
                                '</label>' +
                            '</div>';
                    });
                } else {
                    varContainer.innerHTML = '<p class="text-xs text-gray-400 italic">Belum ada varian.</p>';
                }

                document.getElementById('edit-new-varians-container').innerHTML = '';

                // Render Galeri Tambahan
                var imgContainer = document.getElementById('edit-existing-gambars');
                imgContainer.innerHTML = '';
                if (images && images.length > 0) {
                    images.forEach(function(img) {
                        var imgId = img.id || '';
                        imgContainer.innerHTML +=
                            '<div class="relative group rounded-lg overflow-hidden border border-gray-200 aspect-square">' +
                                '<img src="/storage/' + img.path_gambar + '" class="w-full h-full object-cover">' +
                                '<label class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition cursor-pointer">' +
                                    '<div class="flex items-center gap-2 text-white text-xs font-medium">' +
                                        '<input type="checkbox" name="delete_gambars[]" value="' + imgId + '" class="rounded border-gray-300 text-rose-600">' +
                                        '<span>Hapus</span>' +
                                    '</div>' +
                                '</label>' +
                            '</div>';
                    });
                } else {
                    imgContainer.innerHTML = '<p class="col-span-4 text-xs text-gray-400 italic">Belum ada foto tambahan.</p>';
                }

                document.getElementById('edit-multi-label').textContent = '';

                openModal('modal-edit');

            } catch (e) {
                console.error('Error in openEditModal:', e);
                alert('Gagal memuat data produk untuk edit.\nDetail: ' + e.message);
            }
        }

        function resetFormTambah() {
            document.getElementById('form-tambah').reset();
            document.getElementById('tambah-multi-label').textContent = '';
            document.getElementById('tambah-varians-container').innerHTML = '';
            document.getElementById('tambah-gambar-utama-index').value = '';
            // ✅ FIX: Reset hint harga reseller
            if (tambahHint) tambahHint.classList.add('hidden');
            if (tambahResellerInput) tambahResellerInput.value = '';
            variantIndex = 0;
            refreshTambahFotoUtama();
        }

        function openDeleteModal(id, nama) {
            const baseUrl = '{{ url('admin/produk') }}';
            document.getElementById('form-hapus').action = `${baseUrl}/${id}`;
            document.getElementById('hapus-nama').textContent = nama;
            openModal('modal-hapus');
        }
    </script>
    @endpush

@endsection