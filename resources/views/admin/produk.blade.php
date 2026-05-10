@extends('layouts.admin')

@section('pageTitle', 'Produk — Pelangi Accessories Admin')

@section('nav-produk', 'active')

@section('headerTitle', 'Katalog Produk')

@section('headerActions')
    
@endsection

@section('content')
<button onclick="openModal('modal-tambah')"
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
    <p class="text-sm text-gray-500 mb-6">Kelola inventaris, harga, dan ketersediaan barang.</p>

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

                                    {{-- Edit --}}
                                    <button onclick="openEditModal({{ $produk->id_produk }},
                                                        {{ $produk->id_kategori }},
                                                        '{{ addslashes($produk->nama_produk) }}',
                                                        '{{ addslashes($produk->deskripsi ?? '') }}',
                                                        '{{ $produk->harga }}',
                                                        '{{ $produk->harga_reseller ?? '' }}',
                                                        {{ $produk->stok }})"
                                            class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50
                                                   rounded-lg transition-colors" title="Edit">
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

        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"
             onclick="closeModal('modal-tambah')"></div>

        {{-- Panel --}}
        <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-xl
                    flex flex-col max-h-[90vh] overflow-hidden">

            {{-- Header --}}
            <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-gray-900 flex items-center justify-center">
                        <iconify-icon icon="lucide:plus" class="text-white text-lg"></iconify-icon>
                    </div>
                    <div>
                        <h2 id="modal-tambah-title" class="text-base font-semibold text-gray-900">Tambah Produk Baru</h2>
                        <p class="text-xs text-gray-400 mt-0.5">Isi detail produk di bawah ini</p>
                    </div>
                </div>
                <button onclick="closeModal('modal-tambah')"
                        class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                    <iconify-icon icon="lucide:x" class="text-lg"></iconify-icon>
                </button>
            </div>

            {{-- Body --}}
            <div class="overflow-y-auto flex-1">
                <form id="form-tambah"
                      action="{{ route('admin.produk.store') }}"
                      method="POST"
                      enctype="multipart/form-data"
                      class="px-6 py-5 space-y-4">
                    @csrf

                    {{-- Nama Produk --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1.5">
                            Nama Produk <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="nama_produk" required maxlength="100"
                               placeholder="Contoh: Anting Mutiara Elegan"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm
                                      focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-400
                                      placeholder:text-gray-400 transition">
                    </div>

                    {{-- Kategori --}}
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

                    {{-- Harga + Harga Reseller --}}
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1.5">
                                Harga (Rp) <span class="text-rose-500">*</span>
                            </label>
                            <input type="number" name="harga" required min="0" step="100"
                                   placeholder="75000"
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm
                                          focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-400
                                          placeholder:text-gray-400 transition">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1.5">
                                Harga Reseller (Rp)
                            </label>
                            <input type="number" name="harga_reseller" min="0" step="100"
                                   placeholder="60000 (opsional)"
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm
                                          focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-400
                                          placeholder:text-gray-400 transition">
                        </div>
                    </div>

                    {{-- Stok --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1.5">
                            Stok Awal <span class="text-rose-500">*</span>
                        </label>
                        <input type="number" name="stok" required min="0" value="0"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm
                                      focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-400
                                      transition">
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1.5">Deskripsi</label>
                        <textarea name="deskripsi" rows="3"
                                  placeholder="Deskripsi singkat produk (opsional)…"
                                  class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm
                                         focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-400
                                         placeholder:text-gray-400 resize-none transition"></textarea>
                    </div>

                    {{-- Gambar --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1.5">Foto Produk</label>
                        <label class="flex items-center gap-3 px-4 py-3 rounded-xl border border-dashed
                                      border-gray-300 cursor-pointer hover:border-gray-400 hover:bg-gray-50
                                      transition group">
                            <iconify-icon icon="lucide:image-plus"
                                class="text-gray-400 text-2xl group-hover:text-gray-600 transition"></iconify-icon>
                            <div>
                                <p class="text-sm font-medium text-gray-600 group-hover:text-gray-800 transition"
                                   id="tambah-file-label">Klik untuk pilih foto</p>
                                <p class="text-xs text-gray-400">JPG, PNG, WEBP — maks 2 MB</p>
                            </div>
                            <input type="file" name="gambar_produk" accept="image/*" class="hidden"
                                   onchange="previewGambar(this, 'tambah-preview', 'tambah-file-label')">
                        </label>
                        <img id="tambah-preview" src="" alt="Preview"
                             class="hidden mt-2 h-28 rounded-xl object-cover border border-gray-200">
                    </div>

                </form>
            </div>

            {{-- Footer --}}
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

        <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-xl
                    flex flex-col max-h-[90vh] overflow-hidden">

            {{-- Header --}}
            <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-blue-600 flex items-center justify-center">
                        <iconify-icon icon="lucide:edit-2" class="text-white"></iconify-icon>
                    </div>
                    <div>
                        <h2 id="modal-edit-title" class="text-base font-semibold text-gray-900">Edit Produk</h2>
                        <p class="text-xs text-gray-400 mt-0.5">Perbarui informasi produk</p>
                    </div>
                </div>
                <button onclick="closeModal('modal-edit')"
                        class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                    <iconify-icon icon="lucide:x" class="text-lg"></iconify-icon>
                </button>
            </div>

            {{-- Body --}}
            <div class="overflow-y-auto flex-1">
                <form id="form-edit"
                      action=""
                      method="POST"
                      enctype="multipart/form-data"
                      class="px-6 py-5 space-y-4">
                    @csrf
                    @method('PUT')

                    {{-- Nama Produk --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1.5">
                            Nama Produk <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="edit-nama" name="nama_produk" required maxlength="100"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm
                                      focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400
                                      transition">
                    </div>

                    {{-- Kategori --}}
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

                    {{-- Harga + Harga Reseller --}}
                    <div class="grid grid-cols-2 gap-3">
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
                            <label class="block text-xs font-medium text-gray-700 mb-1.5">
                                Harga Reseller (Rp)
                            </label>
                            <input type="number" id="edit-harga-reseller" name="harga_reseller" min="0" step="100"
                                   placeholder="Opsional"
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm
                                          focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400
                                          placeholder:text-gray-400 transition">
                        </div>
                    </div>

                    {{-- Stok --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1.5">
                            Stok <span class="text-rose-500">*</span>
                        </label>
                        <input type="number" id="edit-stok" name="stok" required min="0"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm
                                      focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400
                                      transition">
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1.5">Deskripsi</label>
                        <textarea id="edit-deskripsi" name="deskripsi" rows="3"
                                  placeholder="Deskripsi singkat produk (opsional)…"
                                  class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm
                                         focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400
                                         placeholder:text-gray-400 resize-none transition"></textarea>
                    </div>

                    {{-- Gambar --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1.5">
                            Ganti Foto Produk
                        </label>
                        <label class="flex items-center gap-3 px-4 py-3 rounded-xl border border-dashed
                                      border-gray-300 cursor-pointer hover:border-blue-400 hover:bg-blue-50/30
                                      transition group">
                            <iconify-icon icon="lucide:image-plus"
                                class="text-gray-400 text-2xl group-hover:text-blue-500 transition"></iconify-icon>
                            <div>
                                <p class="text-sm font-medium text-gray-600 group-hover:text-blue-600 transition"
                                   id="edit-file-label">Klik untuk pilih foto baru</p>
                                <p class="text-xs text-gray-400">Kosongkan jika tidak ingin mengganti</p>
                            </div>
                            <input type="file" name="gambar_produk" accept="image/*" class="hidden"
                                   onchange="previewGambar(this, 'edit-preview', 'edit-file-label')">
                        </label>
                        <img id="edit-preview" src="" alt="Preview"
                             class="hidden mt-2 h-28 rounded-xl object-cover border border-gray-200">
                    </div>

                </form>
            </div>

            {{-- Footer --}}
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

            {{-- Accent strip --}}
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
                            akan dihapus permanen dan tidak dapat dikembalikan.
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

        // Tutup modal saat tekan Escape
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') {
                ['modal-tambah', 'modal-edit', 'modal-hapus'].forEach(closeModal);
            }
        });

        /* ── Preview Gambar ── */
        function previewGambar(input, previewId, labelId) {
            const preview = document.getElementById(previewId);
            const label   = document.getElementById(labelId);
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(input.files[0]);
                label.textContent = input.files[0].name;
            }
        }

        /* ── Buka Modal Edit & isi data ── */
        function openEditModal(id, idKategori, nama, deskripsi, harga, hargaReseller, stok) {
            // Set action URL
            const baseUrl = '{{ url('admin/produk') }}';
            document.getElementById('form-edit').action = `${baseUrl}/${id}`;

            // Isi field
            document.getElementById('edit-nama').value            = nama;
            document.getElementById('edit-deskripsi').value       = deskripsi;
            document.getElementById('edit-harga').value           = harga;
            document.getElementById('edit-harga-reseller').value  = hargaReseller;
            document.getElementById('edit-stok').value            = stok;

            // Set selected kategori
            const selKat = document.getElementById('edit-kategori');
            for (let opt of selKat.options) {
                opt.selected = (opt.value == idKategori);
            }

            // Reset preview gambar
            const preview = document.getElementById('edit-preview');
            preview.src = '';
            preview.classList.add('hidden');
            document.getElementById('edit-file-label').textContent = 'Klik untuk pilih foto baru';

            openModal('modal-edit');
        }

        /* ── Buka Modal Hapus ── */
        function openDeleteModal(id, nama) {
            const baseUrl = '{{ url('admin/produk') }}';
            document.getElementById('form-hapus').action = `${baseUrl}/${id}`;
            document.getElementById('hapus-nama').textContent = nama;
            openModal('modal-hapus');
        }
    </script>
    @endpush

@endsection