<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $produk->nama_produk }} | Pelangi Accessories</title>
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
                    <!-- <button class="relative text-gray-500 hover:text-violet-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </button> -->
                    <a href="{{ route('keranjang.index') }}" class="relative text-gray-500 hover:text-violet-600 transition-colors" id="navCartBtn">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <span id="navCartBadge" class="{{ $cartCount > 0 ? '' : 'hidden' }} absolute -top-2 -right-2 w-5 h-5 bg-pink-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center shadow-sm">{{ $cartCount > 99 ? '99+' : $cartCount }}</span>
                    </a>
                    @auth
                    @php $userName = auth()->user()->name ?? auth()->user()->nama ?? 'Pelanggan'; @endphp
                    <div class="hidden sm:flex items-center space-x-4">
                        <a href="/dashboard" class="text-violet-600 hover:text-pink-400 font-medium transition-colors">{{ $userName }}</a>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-detail').submit();" class="text-gray-400 hover:text-red-500 font-medium transition-colors text-sm">Keluar</a>
                        <form id="logout-detail" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
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
                <li><a href="{{ route('katalog') }}" class="hover:text-violet-600 transition-colors">Katalog</a></li>
                <li><svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></li>
                <li><span class="text-gray-900 line-clamp-1">{{ $produk->nama_produk }}</span></li>
            </ol>
        </nav>

        <!-- ==================== PRODUCT DETAIL ==================== -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">

                <!-- ── LEFT: Product Images ── -->
                <div class="p-6 lg:p-10">
                    <!-- Main Image -->
                    <div class="relative w-full aspect-square rounded-2xl overflow-hidden bg-gray-100 mb-4">
                        <img id="mainImage" src="{{ $produk->gambar_url }}" alt="{{ $produk->nama_produk }}" class="w-full h-full object-cover transition-all duration-300">

                        <!-- Badge -->
                        <div class="absolute top-4 left-4 z-10">
                            <span class="px-3 py-1.5 bg-white/90 backdrop-blur-sm text-violet-700 text-xs uppercase tracking-wider font-bold rounded-lg shadow-sm">
                                {{ $produk->kategori->nama_kategori ?? 'Lainnya' }}
                            </span>
                        </div>
                        @if($produk->created_at->isAfter(now()->subDays(30)))
                        <div class="absolute top-4 right-4 z-10">
                            <span class="px-3 py-1.5 bg-pink-500 text-white text-xs uppercase tracking-wider font-bold rounded-lg shadow-sm">Baru</span>
                        </div>
                        @endif
                    </div>
                    <!-- Thumbnails -->
                    <div class="flex gap-3 overflow-x-auto pb-2">
                        @php
                            // Kumpulkan URL gambar yang sudah ditampilkan supaya tidak duplikat
                            $shownUrls = [];
                        @endphp

                        {{-- Gambar Utama (hanya jika BUKAN sama dengan gambar varian pertama yang terpilih) --}}
                        @php
                            $mainUrl = $produk->gambar_url;
                            $isMainFromVariant = false;
                            foreach($produk->varians as $v) {
                                if ($v->gambar_varian && asset('storage/' . $v->gambar_varian) === $mainUrl) {
                                    $isMainFromVariant = true;
                                    break;
                                }
                            }
                        @endphp

                        @if(!$isMainFromVariant)
                            <button onclick="changeImage('{{ $mainUrl }}', this)" 
                                class="flex-shrink-0 w-20 h-20 rounded-xl overflow-hidden border-2 border-violet-500 ring-2 ring-violet-200 transition-all thumbnail-btn">
                                <img src="{{ $mainUrl }}" alt="Main" class="w-full h-full object-cover">
                            </button>
                            @php $shownUrls[] = $mainUrl; @endphp
                        @endif

                        {{-- Gambar Tambahan dari tabel produk_gambar --}}
                        @foreach($produk->gambars as $gambar)
                            @if(!in_array($gambar->url, $shownUrls))
                            <button onclick="changeImage('{{ $gambar->url }}', this)" 
                                class="flex-shrink-0 w-20 h-20 rounded-xl overflow-hidden border-2 border-gray-200 hover:border-violet-400 transition-all thumbnail-btn">
                                <img src="{{ $gambar->url }}" alt="Foto {{ $loop->iteration }}" class="w-full h-full object-cover">
                            </button>
                            @php $shownUrls[] = $gambar->url; @endphp
                            @endif
                        @endforeach

                        {{-- Gambar dari setiap Varian --}}
                        @foreach($produk->varians as $varian)
                            @if($varian->gambar_varian && !in_array($varian->gambar_varian_url, $shownUrls))
                            <button onclick="changeImage('{{ $varian->gambar_varian_url }}', this)" 
                                class="flex-shrink-0 w-20 h-20 rounded-xl overflow-hidden border-2 border-gray-200 hover:border-violet-400 transition-all thumbnail-btn"
                                title="{{ $varian->nama_varian }}">
                                <img src="{{ $varian->gambar_varian_url }}" alt="{{ $varian->nama_varian }}" class="w-full h-full object-cover">
                            </button>
                            @php $shownUrls[] = $varian->gambar_varian_url; @endphp
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- ── RIGHT: Product Info ── -->
                <div class="p-6 lg:p-10 lg:border-l border-gray-100 flex flex-col">

                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 tracking-tight mb-3">
                        {{ $produk->nama_produk }}
                    </h1>

                    <!-- Rating -->
                    <div class="flex items-center gap-3 mb-6">
                        <div class="flex items-center gap-1">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= floor($avgRating))
                                    <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                @elseif($i - 0.5 <= $avgRating)
                                    <svg class="w-5 h-5 text-yellow-400" viewBox="0 0 20 20">
                                        <defs><linearGradient id="half"><stop offset="50%" stop-color="currentColor"/><stop offset="50%" stop-color="#d1d5db"/></linearGradient></defs>
                                        <path fill="url(#half)" d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 text-gray-300 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                @endif
                            @endfor
                        </div>
                        <span class="text-sm font-bold text-gray-700">{{ number_format($avgRating, 1) }}</span>
                        <span class="text-sm text-gray-400">({{ $totalReviews }} ulasan)</span>
                    </div>

                    <!-- Price -->
                    <div class="mb-8">
                        @php $isReseller = auth()->check() && auth()->user()->role === 'reseller' && $produk->harga_reseller && $produk->harga_reseller > 0; @endphp
                        @if($isReseller)
                            <span class="inline-block px-3 py-1 bg-emerald-50 text-emerald-700 text-xs font-bold rounded-lg mb-2">Harga Khusus Reseller</span>
                        @endif
                        <div class="flex items-baseline gap-3">
                            <span class="text-3xl md:text-4xl font-extrabold {{ $isReseller ? 'text-emerald-600' : 'text-violet-600' }}">{{ $produk->harga_format }}</span>
                            @if($isReseller)
                                <span class="text-lg text-gray-400 line-through">{{ $produk->harga_regular_format }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-8">
                        <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-3">Deskripsi Produk</h3>
                        <p class="text-gray-600 leading-relaxed text-sm">
                            {{ $produk->deskripsi ?? 'Belum ada deskripsi untuk produk ini.' }}
                        </p>
                    </div>

                    <!-- Varian / Warna -->
                    @if($produk->varians->count() > 0)
                    <div class="mb-8">
                        <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-3">Pilihan Varian</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($produk->varians as $index => $varian)
                            <label class="cursor-pointer">
                                <input type="radio" name="varian_id" value="{{ $varian->id }}" 
                                    class="peer sr-only" 
                                    {{ $index === 0 ? 'checked' : '' }} 
                                    onchange="changeVariantImage(this)" 
                                    data-image="{{ $varian->gambar_varian_url }}">
                                
                                <span class="inline-block px-4 py-2.5 rounded-xl text-sm font-semibold border-2 border-gray-200 peer-checked:border-violet-500 peer-checked:bg-violet-50 peer-checked:text-violet-700 transition-all hover:border-violet-300">
                                    {{ $varian->nama_varian }}
                                    <span class="text-xs text-gray-400 ml-1">(Stok: {{ $varian->stok_varian }})</span>
                                </span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @else
                    <!-- Jika tidak ada varian, tampilkan stok global -->
                    <div class="mb-8">
                        <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-3">Stok Tersedia</h3>
                        <p class="text-gray-700 font-semibold">{{ $produk->stok }} pcs</p>
                    </div>
                    @endif

                    <!-- Quantity -->
                    <div class="mb-8">
                        <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-3">Jumlah</h3>
                        <div class="inline-flex items-center border-2 border-gray-200 rounded-xl overflow-hidden">
                            <button type="button" onclick="changeQty(-1)" class="w-12 h-12 flex items-center justify-center text-gray-500 hover:bg-gray-50 hover:text-violet-600 transition-colors font-bold text-lg">−</button>
                            <input type="number" id="qty" name="qty" value="1" min="1" max="99" class="w-16 h-12 text-center font-bold text-gray-900 border-x-2 border-gray-200 focus:outline-none">
                            <button type="button" onclick="changeQty(1)" class="w-12 h-12 flex items-center justify-center text-gray-500 hover:bg-gray-50 hover:text-violet-600 transition-colors font-bold text-lg">+</button>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="mt-auto flex flex-col sm:flex-row gap-3">
                        <button onclick="addToCart({{ $produk->id_produk }})" class="flex-1 flex items-center justify-center gap-2 px-6 py-3.5 border-2 border-violet-600 text-violet-600 rounded-xl font-bold hover:bg-violet-50 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            Tambah ke Keranjang
                        </button>
                        <button onclick="buyNow({{ $produk->id_produk }})" class="flex-1 px-6 py-3.5 bg-gradient-to-r from-violet-600 to-pink-500 text-white rounded-xl font-bold hover:shadow-lg hover:scale-[1.02] transition-all shadow-md shadow-violet-500/20">
                            Beli Sekarang
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- ==================== RATING & ULASAN ==================== -->
        <div class="mt-10 bg-white rounded-2xl border border-gray-100 shadow-sm p-6 lg:p-10">
            <h2 class="text-xl md:text-2xl font-bold text-gray-900 mb-8">Rating & Ulasan</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">

                <!-- Rating Summary -->
                <div class="text-center md:text-left">
                    <div class="text-6xl font-extrabold text-gray-900 mb-2">{{ number_format($avgRating, 1) }}</div>
                    <div class="flex items-center justify-center md:justify-start gap-1 mb-2">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= floor($avgRating))
                                <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @else
                                <svg class="w-5 h-5 text-gray-300 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endif
                        @endfor
                    </div>
                    <p class="text-sm text-gray-500">{{ $totalReviews }} ulasan</p>

                    <!-- Bar Distribution -->
                    <div class="mt-6 space-y-2">
                        @for($i = 5; $i >= 1; $i--)
                        @php $count = $ratingDistribution[$i] ?? 0; $percent = $totalReviews > 0 ? ($count / $totalReviews * 100) : 0; @endphp
                        <div class="flex items-center gap-3 text-sm">
                            <span class="w-3 font-medium text-gray-600">{{ $i }}</span>
                            <svg class="w-4 h-4 text-yellow-400 fill-current flex-shrink-0" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <div class="flex-1 h-2.5 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full bg-yellow-400 rounded-full transition-all duration-500" style="width: {{ $percent }}%"></div>
                            </div>
                            <span class="w-8 text-right text-gray-400 font-medium text-xs">{{ $count }}</span>
                        </div>
                        @endfor
                    </div>
                </div>

                <!-- Reviews List -->
                <div class="md:col-span-2">
                    @if($produk->ratings->count() > 0)
                    <div class="space-y-6 max-h-[500px] overflow-y-auto pr-2">
                        @foreach($produk->ratings->sortByDesc('created_at') as $rating)
                        <div class="border-b border-gray-100 pb-6 last:border-0">
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-full bg-violet-100 flex items-center justify-center text-violet-600 font-bold text-sm flex-shrink-0">
                                    {{ strtoupper(substr($rating->user->name ?? $rating->user->nama ?? 'U', 0, 1)) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between gap-2 mb-1">
                                        <span class="font-semibold text-gray-900 text-sm">{{ $rating->user->name ?? $rating->user->nama ?? 'Anonim' }}</span>
                                        <span class="text-xs text-gray-400 flex-shrink-0">{{ $rating->created_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="flex items-center gap-0.5 mb-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-3.5 h-3.5 {{ $i <= $rating->rating ? 'text-yellow-400 fill-current' : 'text-gray-300 fill-current' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        @endfor
                                    </div>
                                    <p class="text-sm text-gray-600 leading-relaxed">{{ $rating->ulasan ?? $rating->review ?? $rating->komentar ?? '' }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        </div>
                        <p class="text-gray-500 font-medium">Belum ada ulasan untuk produk ini.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- ==================== PRODUK TERKAIT ==================== -->
        @if($relatedProduks->count() > 0)
        <div class="mt-10">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl md:text-2xl font-bold text-gray-900">Produk Serupa</h2>
                <a href="{{ route('katalog', ['id_kategori' => $produk->id_kategori]) }}" class="text-sm font-bold text-violet-600 hover:text-violet-700 transition-colors">
                    Lihat Semua →
                </a>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
                @foreach($relatedProduks as $item)
                <a href="{{ route('produk.detail', $item->id_produk) }}" class="group bg-white rounded-2xl border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300">
                    <div class="relative w-full aspect-square overflow-hidden bg-gray-100">
                        <img src="{{ $item->gambar_url }}" alt="{{ $item->nama_produk }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <!-- <div class="p-4">
                        <h3 class="text-gray-800 font-medium leading-tight mb-1 group-hover:text-violet-600 transition-colors line-clamp-2 text-sm">
                            {{ $item->nama_produk }}
                        </h3>
                        <span class="text-sm font-bold text-violet-600">{{ $item->harga_format }}</span>
                    </div> -->


                    @php $isResellerRelated = auth()->check() && auth()->user()->role === 'reseller' && $item->harga_reseller && $item->harga_reseller > 0; @endphp
                    <div class="flex flex-col">
                        @if($isResellerRelated)
                            <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded-md w-fit mb-0.5">Reseller</span>
                        @endif
                        <span class="text-sm font-bold {{ $isResellerRelated ? 'text-emerald-600' : 'text-violet-600' }}">{{ $item->harga_format }}</span>
                        @if($isResellerRelated)
                            <span class="text-[11px] text-gray-400 line-through">{{ $item->harga_regular_format }}</span>
                        @endif
                    </div>
                </a>
                @endforeach
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

    <!-- ==================== JS ==================== -->
    <!-- <script>
        // ── Change main image from Thumbnail ──
        function changeImage(src, btn) {
            document.getElementById('mainImage').src = src;
            
            // Update active thumbnail border
            document.querySelectorAll('.thumbnail-btn').forEach(b => {
                b.classList.remove('border-violet-500', 'ring-2', 'ring-violet-200');
                b.classList.add('border-gray-200');
            });
            btn.classList.remove('border-gray-200');
            btn.classList.add('border-violet-500', 'ring-2', 'ring-violet-200');
        }

        // ── ✅ BARU: Change main image from Variant (Warna) Selection ──
        function changeVariantImage(radioBtn) {
            const newImageUrl = radioBtn.getAttribute('data-image');
            
            if (newImageUrl) {
                document.getElementById('mainImage').src = newImageUrl;
                
                // Hapus highlight dari semua thumbnail
                document.querySelectorAll('.thumbnail-btn').forEach(btn => {
                    btn.classList.remove('border-violet-500', 'ring-2', 'ring-violet-200');
                    btn.classList.add('border-gray-200');
                });

                // ✅ Highlight thumbnail yang gambarnya cocok dengan varian dipilih
                document.querySelectorAll('.thumbnail-btn').forEach(btn => {
                    const thumbImg = btn.querySelector('img');
                    if (thumbImg && thumbImg.src === newImageUrl) {
                        btn.classList.remove('border-gray-200');
                        btn.classList.add('border-violet-500', 'ring-2', 'ring-violet-200');
                    }
                });
            }
        }
        // ── Quantity ──
        function changeQty(delta) {
            const input = document.getElementById('qty');
            let val = parseInt(input.value) || 1;
            val = Math.max(1, Math.min(99, val + delta));
            input.value = val;
        }

        // ── Add to Cart (placeholder) ──
        function addToCart(produkId) {
            const qty = document.getElementById('qty').value;
            alert('Tambah ke keranjang: Produk ID ' + produkId + ', Jumlah: ' + qty);
            // TODO: Implement with AJAX/fetch
        }

        // ── Buy Now (placeholder) ──
        function buyNow(produkId) {
            const qty = document.getElementById('qty').value;
            alert('Beli sekarang: Produk ID ' + produkId + ', Jumlah: ' + qty);
            // TODO: Implement with form submission
        }

        // ── ✅ BARU: Saat halaman dimuat, paksa gambar utama mengikuti varian pertama ──
        document.addEventListener('DOMContentLoaded', function() {
            const firstVariant = document.querySelector('input[name="varian_id"]:checked');
            if (firstVariant) {
                changeVariantImage(firstVariant);
            }
        });
    </script> -->

    <script>
    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
        || document.querySelector('input[name="_token"]')?.value;

    // ── Change main image from Thumbnail ──
    function changeImage(src, btn) {
        document.getElementById('mainImage').src = src;
        document.querySelectorAll('.thumbnail-btn').forEach(b => {
            b.classList.remove('border-violet-500', 'ring-2', 'ring-violet-200');
            b.classList.add('border-gray-200');
        });
        btn.classList.remove('border-gray-200');
        btn.classList.add('border-violet-500', 'ring-2', 'ring-violet-200');
    }

    // ── Change main image from Variant Selection ──
    function changeVariantImage(radioBtn) {
        const newImageUrl = radioBtn.getAttribute('data-image');
        if (newImageUrl) {
            document.getElementById('mainImage').src = newImageUrl;
            document.querySelectorAll('.thumbnail-btn').forEach(btn => {
                btn.classList.remove('border-violet-500', 'ring-2', 'ring-violet-200');
                btn.classList.add('border-gray-200');
            });
            document.querySelectorAll('.thumbnail-btn').forEach(btn => {
                const thumbImg = btn.querySelector('img');
                if (thumbImg && thumbImg.src === newImageUrl) {
                    btn.classList.remove('border-gray-200');
                    btn.classList.add('border-violet-500', 'ring-2', 'ring-violet-200');
                }
            });
        }
    }

    // ── Quantity ──
    function changeQty(delta) {
        const input = document.getElementById('qty');
        let val = parseInt(input.value) || 1;
        val = Math.max(1, Math.min(99, val + delta));
        input.value = val;
    }

    // ── Toast Notification ──
    let toastTimeout;
    function showToast(message, type = 'success') {
        let toast = document.getElementById('detailToast');
        if (!toast) {
            toast = document.createElement('div');
            toast.id = 'detailToast';
            toast.className = 'fixed top-6 right-6 z-[100] transform translate-x-[120%] transition-transform duration-300 ease-out';
            toast.innerHTML = `
                <div class="bg-white border border-gray-200 shadow-2xl rounded-xl px-5 py-4 flex items-center gap-3 max-w-sm">
                    <div id="detailToastIcon" class="flex-shrink-0"></div>
                    <p id="detailToastMsg" class="text-sm font-medium text-gray-700"></p>
                </div>`;
            document.body.appendChild(toast);
        }
        const iconEl = document.getElementById('detailToastIcon');
        const msgEl  = document.getElementById('detailToastMsg');
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

    // ── Update Cart Badge di Navbar ──
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

    // ── Add to Cart (AJAX) ──
    function addToCart(produkId) {
        @guest
        showToast('Silakan login terlebih dahulu untuk menambahkan ke keranjang.', 'info');
        setTimeout(() => { window.location.href = '{{ route("login") }}'; }, 1500);
        return;
        @endguest

        const qty        = document.getElementById('qty').value;
        const varianRadio = document.querySelector('input[name="varian_id"]:checked');
        const idVarian   = varianRadio ? varianRadio.value : null;

        fetch('{{ route("keranjang.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                id_produk: produkId,
                kuantitas: parseInt(qty),
                id_varian: idVarian,
            }),
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showToast(data.message, 'success');
                updateCartBadge(data.total_items);
            } else {
                showToast(data.message || 'Gagal menambahkan ke keranjang.', 'error');
            }
        })
        .catch(() => showToast('Terjadi kesalahan jaringan.', 'error'));
    }

    // ── Buy Now ──
    function buyNow(produkId) {
        @guest
        showToast('Silakan login terlebih dahulu.', 'info');
        setTimeout(() => { window.location.href = '{{ route("login") }}'; }, 1500);
        return;
        @endguest

        const qty        = document.getElementById('qty').value;
        const varianRadio = document.querySelector('input[name="varian_id"]:checked');
        const idVarian   = varianRadio ? varianRadio.value : null;

        fetch('{{ route("keranjang.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                id_produk: produkId,
                kuantitas: parseInt(qty),
                id_varian: idVarian,
            }),
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                window.location.href = '{{ route("keranjang.index") }}';
            } else {
                showToast(data.message || 'Gagal menambahkan ke keranjang.', 'error');
            }
        })
        .catch(() => showToast('Terjadi kesalahan jaringan.', 'error'));
    }

    // ── Init: Paksa gambar utama mengikuti varian pertama ──
    document.addEventListener('DOMContentLoaded', function() {
        const firstVariant = document.querySelector('input[name="varian_id"]:checked');
        if (firstVariant) {
            changeVariantImage(firstVariant);
        }
    });
</script>
</body>
</html>