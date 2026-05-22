<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja | Pelangi Accessories</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Poppins', 'sans-serif'] }
                }
            }
        }
    </script>
    <style>
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #d1d5db; }

        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }

        .cart-item { transition: opacity 300ms ease, transform 300ms ease; }
        .cart-item.removing { opacity: 0; transform: translateX(40px); }
    </style>
</head>

<body class="bg-gray-50 font-sans text-gray-800 antialiased selection:bg-violet-200 selection:text-violet-800 flex flex-col min-h-screen">

    <!-- ==================== NAVBAR ==================== -->
    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex-shrink-0 flex items-center mr-8 lg:mr-12">
                    <a href="{{ route('home') }}" class="text-xl md:text-2xl font-bold flex items-center gap-2">
                        <img src="{{ asset('storage/image/logo.png') }}" alt="Logo Pelangi" class="w-8 h-8 md:w-10 md:h-10 object-contain" onerror="this.outerHTML='<div class=\'w-8 h-8 md:w-10 md:h-10 bg-gray-200 rounded-full flex items-center justify-center text-[10px] text-gray-500\'>Logo</div>'">
                        <span class="text-gray-900">Pelangi</span> <span class="text-pink-500">Accessories</span>
                    </a>
                </div>

                <div class="hidden md:flex space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-500 hover:text-violet-600 transition-colors font-medium">Beranda</a>
                    <a href="{{ route('katalog') }}" class="text-gray-500 hover:text-violet-600 transition-colors font-medium">Katalog</a>
                    <a href="{{ route('about') }}" class="text-gray-500 hover:text-violet-600 transition-colors font-medium">Tentang Kami</a>
                </div>

                <div class="hidden lg:flex flex-1 max-w-md mx-8">
                    <form action="{{ route('katalog') }}" method="GET" class="relative w-full">
                        <input type="text" name="search" placeholder="Cari aksesoris..." class="w-full bg-gray-100 rounded-full py-2.5 pl-5 pr-10 text-sm focus:outline-none focus:ring-2 focus:ring-violet-300 focus:bg-white border border-transparent focus:border-violet-300 transition-all">
                        <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-violet-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </button>
                    </form>
                </div>

                <div class="flex items-center space-x-6">
                    {{-- Cart Icon with Badge --}}
                    <a href="{{ route('keranjang.index') }}" class="relative text-violet-600 transition-colors" id="navCartBtn">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <span id="navCartBadge" class="{{ $cartCount > 0 ? '' : 'hidden' }} absolute -top-2 -right-2 w-5 h-5 bg-pink-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center shadow-sm">{{ $cartCount > 99 ? '99+' : $cartCount }}</span>
                    </a>

                    @auth
                    @php $userName = auth()->user()->name ?? auth()->user()->nama ?? 'Pelanggan'; @endphp
                    <div class="hidden sm:flex items-center space-x-4">
                        <a href="/dashboard" class="text-violet-600 hover:text-pink-400 font-medium transition-colors">{{ $userName }}</a>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-cart').submit();" class="text-gray-400 hover:text-red-500 font-medium transition-colors text-sm">Keluar</a>
                        <form id="logout-cart" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
                    </div>
                    @endauth

                    @guest
                    <div class="hidden sm:flex items-center space-x-4">
                        <a href="/login" class="text-gray-500 hover:text-violet-600 font-medium transition-colors">Masuk</a>
                        <a href="/register" class="bg-gradient-to-r from-violet-600 to-pink-400 text-white px-6 py-2.5 rounded-full font-medium hover:shadow-lg hover:scale-105 transition-all">Daftar</a>
                    </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- ==================== MAIN ==================== -->
    <main class="flex-1 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Breadcrumbs -->
        <nav class="flex text-sm font-medium text-gray-500 mb-8">
            <ol class="flex items-center space-x-2">
                <li><a href="{{ route('home') }}" class="hover:text-violet-600 transition-colors">Beranda</a></li>
                <li><svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></li>
                <li><span class="text-gray-900">Keranjang Belanja</span></li>
            </ol>
        </nav>

        @if($keranjang && $keranjang->details->count() > 0)

        {{-- ── Cart Header ── --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Keranjang Belanja</h1>
                <p class="text-gray-500 text-sm mt-1">{{ $keranjang->details->count() }} item &middot; {{ $keranjang->total_items }} produk</p>
            </div>
            <button onclick="clearCart()" class="text-sm font-semibold text-red-400 hover:text-red-600 transition-colors flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                Kosongkan
            </button>
        </div>

        <div class="flex flex-col lg:flex-row gap-8 items-start">

            {{-- ══════════════════════════════════════
                 LEFT: Cart Items
                 ══════════════════════════════════════ --}}
            <div class="flex-1 w-full space-y-4" id="cartItemsContainer">

                @foreach($keranjang->details as $detail)
                @php
                    $produk = $detail->produk;
                    $varian = $detail->varian;
                    $gambar = $varian && $varian->gambar_varian_url
                                ? $varian->gambar_varian_url
                                : ($produk ? $produk->gambar_url : asset('images/no-image.png'));
                    $namaProduk = $produk ? $produk->nama_produk : 'Produk tidak tersedia';
                    $stokInfo   = $varian ? $varian->stok_varian : ($produk ? $produk->stok : 0);
                    $isOutOfStock = $detail->kuantitas > $stokInfo;
                @endphp

                <div class="cart-item bg-white rounded-2xl border {{ $isOutOfStock ? 'border-red-200 bg-red-50/30' : 'border-gray-100' }} shadow-sm p-4 sm:p-6" data-detail-id="{{ $detail->id_keranjang_detail }}">

                    <div class="flex gap-4 sm:gap-6">

                        {{-- Image --}}
                        <a href="{{ $produk ? route('produk.detail', $produk->id_produk) : '#' }}" class="flex-shrink-0">
                            <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-xl overflow-hidden bg-gray-100 border border-gray-100">
                                <img src="{{ $gambar }}" alt="{{ $namaProduk }}" class="w-full h-full object-cover">
                            </div>
                        </a>

                        {{-- Info --}}
                        <div class="flex-1 min-w-0 flex flex-col">
                            <div class="flex items-start justify-between gap-2 mb-1">
                                <a href="{{ $produk ? route('produk.detail', $produk->id_produk) : '#' }}" class="font-semibold text-gray-900 hover:text-violet-600 transition-colors line-clamp-2 text-sm sm:text-base leading-tight">
                                    {{ $namaProduk }}
                                </a>
                                {{-- Remove Button --}}
                                <button onclick="removeItem({{ $detail->id_keranjang_detail }})" class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-full text-gray-300 hover:text-red-500 hover:bg-red-50 transition-colors" title="Hapus item">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>

                            {{-- Variant badge --}}
                            @if($varian)
                            <span class="inline-block px-2.5 py-0.5 bg-violet-50 text-violet-600 text-xs font-semibold rounded-md mb-2 w-fit">
                                {{ $varian->nama_varian }}
                            </span>
                            @endif

                            {{-- Out of stock warning --}}
                            @if($isOutOfStock)
                            <span class="inline-block px-2.5 py-0.5 bg-red-50 text-red-600 text-xs font-semibold rounded-md mb-2">
                                ⚠ Stok tersisa {{ $stokInfo }}
                            </span>
                            @endif

                            {{-- Price + Qty row --}}
                            <div class="mt-auto flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <div>
                                    @php $isReseller = auth()->check() && auth()->user()->role === 'reseller' && $produk && $produk->harga_reseller && $produk->harga_reseller > 0; @endphp
                                    @if($isReseller)
                                    <!-- <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded-md">Reseller</span> -->
                                    @endif
                                    <span class="text-base sm:text-lg font-bold {{ $isReseller ? 'text-emerald-600' : 'text-violet-600' }}">
                                        {{ $produk ? $produk->harga_format : '-' }}
                                    </span>
                                    @if($isReseller && $produk)
                                    <span class="text-xs text-gray-400 line-through ml-1">{{ $produk->harga_regular_format }}</span>
                                    @endif
                                </div>

                                <div class="flex items-center gap-4">
                                    {{-- Quantity Controls --}}
                                    <div class="inline-flex items-center border-2 border-gray-200 rounded-xl overflow-hidden">
                                        <button type="button" onclick="updateQty({{ $detail->id_keranjang_detail }}, -1)" class="w-9 h-9 flex items-center justify-center text-gray-500 hover:bg-gray-50 hover:text-violet-600 transition-colors font-bold">−</button>
                                        <span class="w-10 h-9 flex items-center justify-center font-bold text-gray-900 text-sm border-x-2 border-gray-200" id="qty-{{ $detail->id_keranjang_detail }}">{{ $detail->kuantitas }}</span>
                                        <button type="button" onclick="updateQty({{ $detail->id_keranjang_detail }}, 1)" class="w-9 h-9 flex items-center justify-center text-gray-500 hover:bg-gray-50 hover:text-violet-600 transition-colors font-bold">+</button>
                                    </div>

                                    {{-- Subtotal --}}
                                    <span class="text-sm sm:text-base font-bold text-gray-900 min-w-[80px] text-right" id="subtotal-{{ $detail->id_keranjang_detail }}">
                                        Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>

            {{-- ══════════════════════════════════════
                 RIGHT: Order Summary
                 ══════════════════════════════════════ --}}
            <div class="w-full lg:w-80 xl:w-96 flex-shrink-0 lg:sticky lg:top-28">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">

                    <h2 class="text-lg font-bold text-gray-900 mb-6">Ringkasan Belanja</h2>

                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500">Total Harga ({{ $keranjang->total_items }} produk)</span>
                            <span class="font-semibold text-gray-700" id="summarySubtotal">Rp {{ number_format($keranjang->total_harga, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500">Ongkos Kirim</span>
                            <span class="font-semibold text-gray-500">Dihitung saat checkout</span>
                        </div>
                    </div>

                    <hr class="my-5 border-gray-100">

                    <div class="flex justify-between items-center mb-6">
                        <span class="text-base font-bold text-gray-900">Total</span>
                        <span class="text-xl font-extrabold text-violet-600" id="summaryTotal">Rp {{ number_format($keranjang->total_harga, 0, ',', '.') }}</span>
                    </div>

                    <a href="{{ route('checkout.index') }}" class="block w-full py-3.5 bg-gradient-to-r from-violet-600 to-pink-500 text-white rounded-xl font-bold hover:shadow-lg hover:scale-[1.02] transition-all shadow-md shadow-violet-500/20 text-sm text-center">
                        Checkout Sekarang
                    </a>

                    <a href="{{ route('katalog') }}" class="block text-center mt-4 text-sm font-semibold text-violet-600 hover:text-violet-700 transition-colors">
                        ← Lanjut Belanja
                    </a>

                    {{-- Trust badges --}}
                    <div class="mt-6 pt-5 border-t border-gray-100 space-y-3">
                        <div class="flex items-center gap-3 text-xs text-gray-400">
                            <svg class="w-5 h-5 text-emerald-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            <span>Pembayaran 100% Aman</span>
                        </div>
                        <div class="flex items-center gap-3 text-xs text-gray-400">
                            <svg class="w-5 h-5 text-emerald-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                            <span>Garansi Pengembalian 7 Hari</span>
                        </div>
                        <div class="flex items-center gap-3 text-xs text-gray-400">
                            <svg class="w-5 h-5 text-emerald-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                            <span>Pengiriman Cepat & Aman</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        @else

        {{-- ══════════════════════════════════════
             EMPTY CART STATE
             ══════════════════════════════════════ --}}
        <div class="text-center py-20">
            <div class="w-28 h-28 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6 border-2 border-dashed border-gray-200">
                <svg class="w-14 h-14 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-3">Keranjang Anda Kosong</h2>
            <p class="text-gray-500 mb-8 max-w-sm mx-auto">Yuk mulai belanja dan temukan aksesoris favoritmu di Pelangi Accessories!</p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                <a href="{{ route('katalog') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-violet-600 to-pink-500 text-white px-8 py-3.5 rounded-full font-bold hover:shadow-lg hover:scale-105 transition-all shadow-md shadow-violet-500/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    Mulai Belanja
                </a>
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-violet-600 font-semibold transition-colors">
                    ← Kembali ke Beranda
                </a>
            </div>
        </div>

        @endif

    </main>

    <!-- ==================== FOOTER ==================== -->
    <footer class="bg-white border-t border-gray-200 pt-16 pb-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <a href="{{ route('home') }}" class="text-xl font-bold flex items-center justify-center gap-2 mb-4">
                    <span class="text-gray-900">Pelangi</span> <span class="text-pink-500">Accessories</span>
                </a>
                <p class="text-gray-400 text-sm">&copy; {{ date('Y') }} Pelangi Accessories. Hak Cipta Dilindungi.</p>
            </div>
        </div>
    </footer>

    <!-- ==================== TOAST NOTIFICATION ==================== -->
    <div id="toast" class="fixed top-6 right-6 z-[100] transform translate-x-[120%] transition-transform duration-300 ease-out">
        <div class="bg-white border border-gray-200 shadow-2xl rounded-xl px-5 py-4 flex items-center gap-3 max-w-sm">
            <div id="toastIcon" class="flex-shrink-0"></div>
            <div>
                <p id="toastMessage" class="text-sm font-medium text-gray-700"></p>
            </div>
        </div>
    </div>

    <!-- ==================== CONFIRM MODAL ==================== -->
    <div id="confirmModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4" style="display:none;">
        <div class="absolute inset-0 bg-black/40" onclick="closeConfirmModal()"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl p-6 max-w-sm w-full text-center transform scale-95 opacity-0 transition-all duration-200" id="confirmModalContent">
            <div class="w-14 h-14 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2" id="confirmModalTitle">Kosongkan Keranjang?</h3>
            <p class="text-sm text-gray-500 mb-6" id="confirmModalDesc">Semua produk di keranjang akan dihapus. Tindakan ini tidak dapat dibatalkan.</p>
            <div class="flex gap-3">
                <button onclick="closeConfirmModal()" class="flex-1 py-2.5 border-2 border-gray-200 text-gray-700 rounded-xl font-bold hover:bg-gray-50 transition-colors">Batal</button>
                <button id="confirmModalAction" class="flex-1 py-2.5 bg-red-500 text-white rounded-xl font-bold hover:bg-red-600 transition-colors">Hapus</button>
            </div>
        </div>
    </div>

    <!-- ==================== JAVASCRIPT ==================== -->
    <script>
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            || document.querySelector('input[name="_token"]')?.value;

        // ── Toast Notification ──
        let toastTimeout;
        function showToast(message, type = 'success') {
            const toast    = document.getElementById('toast');
            const iconEl   = document.getElementById('toastIcon');
            const msgEl    = document.getElementById('toastMessage');

            msgEl.textContent = message;

            const icons = {
                success: '<div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center"><svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></div>',
                error:   '<div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center"><svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></div>',
                info:    '<div class="w-8 h-8 bg-violet-100 rounded-full flex items-center justify-center"><svg class="w-5 h-5 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>',
            };
            iconEl.innerHTML = icons[type] || icons.success;

            toast.classList.remove('translate-x-[120%]');
            toast.classList.add('translate-x-0');

            clearTimeout(toastTimeout);
            toastTimeout = setTimeout(() => {
                toast.classList.remove('translate-x-0');
                toast.classList.add('translate-x-[120%]');
            }, 3000);
        }

        // ── Update Cart Badge ──
        function updateCartBadge(count) {
            const badge = document.getElementById('navCartBadge');
            if (!badge) return;
            if (count > 0) {
                badge.textContent = count > 99 ? '99+' : count;
                badge.classList.remove('hidden');
            } else {
                badge.classList.add('hidden');
            }
        }

        // ── Update Quantity ──
        function updateQty(detailId, delta) {
            const qtyEl = document.getElementById('qty-' + detailId);
            if (!qtyEl) return;

            let newQty = parseInt(qtyEl.textContent) + delta;
            if (newQty < 1) {
                removeItem(detailId);
                return;
            }
            if (newQty > 99) return;

            qtyEl.textContent = newQty;

            fetch('{{ route("keranjang.update", 0) }}'.replace('/0', '/' + detailId), {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ kuantitas: newQty }),
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Update subtotal item
                    const subtotalEl = document.getElementById('subtotal-' + detailId);
                    if (subtotalEl && data.subtotal_item) {
                        subtotalEl.textContent = data.subtotal_item;
                    }
                    // Update summary
                    if (data.total_harga) {
                        document.getElementById('summarySubtotal').textContent = data.total_harga;
                        document.getElementById('summaryTotal').textContent    = data.total_harga;
                    }
                    updateCartBadge(data.total_items);
                } else {
                    qtyEl.textContent = parseInt(qtyEl.textContent) - delta;
                    showToast(data.message || 'Gagal memperbarui.', 'error');
                }
            })
            .catch(() => {
                qtyEl.textContent = parseInt(qtyEl.textContent) - delta;
                showToast('Terjadi kesalahan.', 'error');
            });
        }

        // ── Remove Item ──
        function removeItem(detailId) {
            const itemEl = document.querySelector(`.cart-item[data-detail-id="${detailId}"]`);

            fetch('{{ route("keranjang.destroy", 0) }}'.replace('/0', '/' + detailId), {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json',
                },
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Animate removal
                    if (itemEl) {
                        itemEl.classList.add('removing');
                        setTimeout(() => {
                            itemEl.remove();
                            checkIfEmpty();
                        }, 300);
                    }
                    updateCartBadge(data.total_items);
                    showToast(data.message, 'success');
                    // Update summary
                    if (data.total_harga) {
                        document.getElementById('summarySubtotal').textContent = data.total_harga;
                        document.getElementById('summaryTotal').textContent    = data.total_harga;
                    }
                } else {
                    showToast(data.message || 'Gagal menghapus.', 'error');
                }
            })
            .catch(() => showToast('Terjadi kesalahan.', 'error'));
        }

        // ── Clear Cart ──
        function clearCart() {
            showConfirmModal(
                'Kosongkan Keranjang?',
                'Semua produk di keranjang akan dihapus. Tindakan ini tidak dapat dibatalkan.',
                function () {
                    fetch('{{ route("keranjang.clear") }}', {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': CSRF_TOKEN,
                            'Accept': 'application/json',
                        },
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            updateCartBadge(0);
                            // Reload to show empty state
                            window.location.reload();
                        }
                    })
                    .catch(() => showToast('Terjadi kesalahan.', 'error'));
                }
            );
        }

        // ── Check if cart is empty (after removal) ──
        function checkIfEmpty() {
            const remaining = document.querySelectorAll('.cart-item:not(.removing)');
            if (remaining.length === 0) {
                window.location.reload();
            }
        }

        // ── Confirm Modal ──
        function showConfirmModal(title, desc, onConfirm) {
            const modal    = document.getElementById('confirmModal');
            const content  = document.getElementById('confirmModalContent');
            const titleEl  = document.getElementById('confirmModalTitle');
            const descEl   = document.getElementById('confirmModalDesc');
            const actionEl = document.getElementById('confirmModalAction');

            titleEl.textContent  = title;
            descEl.textContent   = desc;

            // Clone & replace to remove old listeners
            const newAction = actionEl.cloneNode(true);
            actionEl.parentNode.replaceChild(newAction, actionEl);
            newAction.addEventListener('click', function () {
                onConfirm();
                closeConfirmModal();
            });

            modal.style.display = '';
            document.body.style.overflow = 'hidden';

            requestAnimationFrame(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            });
        }

        function closeConfirmModal() {
            const modal   = document.getElementById('confirmModal');
            const content = document.getElementById('confirmModalContent');

            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');

            setTimeout(() => {
                modal.style.display = 'none';
                document.body.style.overflow = '';
            }, 200);
        }
    </script>

</body>
</html>