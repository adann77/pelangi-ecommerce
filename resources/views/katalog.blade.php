<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Produk | Pelangi Accessories</title>
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

        .range-slider { position: relative; width: 100%; height: 6px; background-color: #f3f4f6; border-radius: 9999px; margin-top: 1rem; margin-bottom: 1.5rem; }
        .range-slider input[type="range"] { position: absolute; width: 100%; height: 6px; appearance: none; background: transparent; pointer-events: none; top: 0; margin: 0; }
        .range-slider input[type="range"]::-webkit-slider-thumb { appearance: none; pointer-events: auto; width: 20px; height: 20px; border-radius: 50%; background: white; border: 2px solid #7c3aed; cursor: pointer; box-shadow: 0 2px 4px rgba(0,0,0,0.1); position: relative; z-index: 20; }
        .range-slider input[type="range"]::-moz-range-thumb { appearance: none; pointer-events: auto; width: 20px; height: 20px; border-radius: 50%; background: white; border: 2px solid #7c3aed; cursor: pointer; box-shadow: 0 2px 4px rgba(0,0,0,0.1); position: relative; z-index: 20; }
        .slider-track { position: absolute; height: 100%; background-color: #7c3aed; border-radius: 9999px; z-index: 10; }

        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }

        .mobile-overlay { transition: opacity 300ms ease-out; }
        .mobile-panel { transition: transform 300ms ease-out; }
    </style>
</head>

@php
    $currentKategori = request('id_kategori', '');
    $currentSearch   = request('search', '');
    $currentMinPrice = request('min_price', 0);
    $currentMaxPrice = request('max_price', $maxPriceLimit);
    $currentSort     = request('sort', 'newest');
    $isFiltered      = $currentKategori || $currentSearch || $currentMinPrice > 0 || $currentMaxPrice < $maxPriceLimit;
@endphp

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
                    <a href="{{ route('katalog') }}" class="text-violet-600 font-semibold relative">
                        Katalog
                        <span class="absolute -bottom-1.5 left-0 w-full h-0.5 bg-violet-600 rounded-full"></span>
                    </a>
                    <a href="{{ route('about') }}" class="text-gray-500 hover:text-violet-600 transition-colors font-medium">Tentang Kami</a>
                </div>

                <div class="hidden lg:flex flex-1 max-w-md mx-8">
                    <form action="{{ route('katalog') }}" method="GET" class="relative w-full">
                        <input type="text" name="search" value="{{ $currentSearch }}" placeholder="Cari aksesoris..." class="w-full bg-gray-100 rounded-full py-2.5 pl-5 pr-10 text-sm focus:outline-none focus:ring-2 focus:ring-violet-300 focus:bg-white border border-transparent focus:border-violet-300 transition-all">
                        <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-violet-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </button>
                    </form>
                </div>

                <div class="flex items-center space-x-6">
                    <button class="relative text-gray-500 hover:text-violet-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </button>

                    @auth
                    @php $userName = auth()->user()->name ?? auth()->user()->nama ?? 'Pelanggan'; @endphp
                    <div class="hidden sm:flex items-center space-x-4">
                        <a href="/dashboard" class="text-violet-600 hover:text-pink-400 font-medium transition-colors">{{ $userName }}</a>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-katalog').submit();" class="text-gray-400 hover:text-red-500 font-medium transition-colors text-sm">Keluar</a>
                        <form id="logout-katalog" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
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
                <li><span class="text-gray-900">Katalog Produk</span></li>
            </ol>
        </nav>

        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 tracking-tight mb-2">
                    {{ $selectedKategori ? $selectedKategori->nama_kategori : 'Semua Koleksi' }}
                </h1>
                <p class="text-gray-500 font-medium">Menampilkan {{ $produks->count() }} produk pilihan untukmu</p>
            </div>

            <div class="flex items-center gap-3">
                <button onclick="openMobileFilter()" class="md:hidden flex items-center justify-center gap-2 px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm font-bold text-gray-700 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                    Filter
                </button>

                <!-- Sort Form -->
                <form method="GET" action="{{ route('katalog') }}" class="relative flex-1 md:w-48">
                    @if($currentKategori)<input type="hidden" name="id_kategori" value="{{ $currentKategori }}">@endif
                    @if($currentSearch)<input type="hidden" name="search" value="{{ $currentSearch }}">@endif
                    @if($currentMinPrice > 0)<input type="hidden" name="min_price" value="{{ $currentMinPrice }}">@endif
                    @if($currentMaxPrice < $maxPriceLimit)<input type="hidden" name="max_price" value="{{ $currentMaxPrice }}">@endif

                    <select name="sort" onchange="this.form.submit()" class="w-full appearance-none bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-xl px-4 py-2.5 pr-10 focus:outline-none focus:ring-2 focus:ring-violet-500/20 focus:border-violet-400 shadow-sm cursor-pointer">
                        <option value="newest" {{ $currentSort == 'newest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="price_asc" {{ $currentSort == 'price_asc' ? 'selected' : '' }}>Harga: Rendah ke Tinggi</option>
                        <option value="price_desc" {{ $currentSort == 'price_desc' ? 'selected' : '' }}>Harga: Tinggi ke Rendah</option>
                        <option value="popular" {{ $currentSort == 'popular' ? 'selected' : '' }}>Terpopuler</option>
                    </select>
                    <svg class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </form>
            </div>
        </div>

        <!-- Content Layout -->
        <div class="flex flex-col md:flex-row gap-8 items-start">

            <!-- ==================== SIDEBAR (Desktop) ==================== -->
            <aside class="hidden md:block w-64 flex-shrink-0 sticky top-28">
                <form id="filterForm" method="GET" action="{{ route('katalog') }}" class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                    <input type="hidden" name="sort" value="{{ $currentSort }}">

                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg font-bold text-gray-900">Filter</h2>
                        @if($isFiltered)
                        <a href="{{ route('katalog') }}" class="text-xs font-bold text-pink-500 hover:text-pink-600 transition-colors uppercase tracking-wider">Reset</a>
                        @endif
                    </div>

                    <!-- Kategori -->
                    <div class="mb-8">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Kategori Produk</h3>
                        <div class="flex flex-col gap-2">
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <div class="relative flex items-center justify-center w-5 h-5">
                                    <input type="radio" name="id_kategori" value="" {{ !$currentKategori ? 'checked' : '' }} class="peer sr-only">
                                    <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:border-violet-600 peer-checked:bg-violet-600 transition-colors"></div>
                                    <div class="absolute w-2 h-2 bg-white rounded-full scale-0 peer-checked:scale-100 transition-transform"></div>
                                </div>
                                <span class="text-sm font-medium {{ !$currentKategori ? 'text-gray-900 font-semibold' : 'text-gray-600 group-hover:text-gray-900' }} transition-colors">Semua</span>
                            </label>

                            @foreach($kategoris as $kat)
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <div class="relative flex items-center justify-center w-5 h-5">
                                    <input type="radio" name="id_kategori" value="{{ $kat->id_kategori }}" {{ $currentKategori == $kat->id_kategori ? 'checked' : '' }} class="peer sr-only">
                                    <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:border-violet-600 peer-checked:bg-violet-600 transition-colors"></div>
                                    <div class="absolute w-2 h-2 bg-white rounded-full scale-0 peer-checked:scale-100 transition-transform"></div>
                                </div>
                                <span class="text-sm font-medium {{ $currentKategori == $kat->id_kategori ? 'text-gray-900 font-semibold' : 'text-gray-600 group-hover:text-gray-900' }} transition-colors">{{ $kat->nama_kategori }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <hr class="border-gray-100 mb-8">

                    <!-- Harga -->
                    <div class="mb-6">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Rentang Harga</h3>

                        <div class="range-slider">
                            <div class="slider-track" id="sliderTrackDesktop"></div>
                            <input type="range" id="minRangeDesktop" min="0" max="{{ $maxPriceLimit }}" step="10000" value="{{ $currentMinPrice }}">
                            <input type="range" id="maxRangeDesktop" min="0" max="{{ $maxPriceLimit }}" step="10000" value="{{ $currentMaxPrice }}">
                        </div>

                        <div class="flex items-center justify-between gap-3 mt-6">
                            <div class="flex-1">
                                <label class="text-[10px] font-bold text-gray-400 uppercase">Min</label>
                                <div class="relative mt-1">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 text-sm font-medium">Rp</span>
                                    <input type="number" id="minInputDesktop" name="min_price" value="{{ $currentMinPrice }}" min="0" max="{{ $maxPriceLimit }}" step="10000" class="w-full bg-gray-50 border border-gray-200 rounded-lg pl-9 pr-3 py-2 text-sm font-bold text-gray-900 focus:outline-none focus:border-violet-400 focus:ring-1 focus:ring-violet-400">
                                </div>
                            </div>
                            <div class="text-gray-400 font-bold mt-5">-</div>
                            <div class="flex-1">
                                <label class="text-[10px] font-bold text-gray-400 uppercase">Max</label>
                                <div class="relative mt-1">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 text-sm font-medium">Rp</span>
                                    <input type="number" id="maxInputDesktop" name="max_price" value="{{ $currentMaxPrice }}" min="0" max="{{ $maxPriceLimit }}" step="10000" class="w-full bg-gray-50 border border-gray-200 rounded-lg pl-9 pr-3 py-2 text-sm font-bold text-gray-900 focus:outline-none focus:border-violet-400 focus:ring-1 focus:ring-violet-400">
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full mt-4 bg-violet-600 text-white py-2.5 rounded-xl font-bold hover:bg-violet-700 transition-colors shadow-md shadow-violet-500/20">
                        Terapkan Filter
                    </button>
                </form>
            </aside>

            <!-- ==================== PRODUCT GRID ==================== -->
            <section class="flex-1 w-full">

                <!-- Active Filters -->
                @if($isFiltered)
                <div class="flex flex-wrap items-center gap-2 mb-6">
                    <span class="text-sm text-gray-500 font-medium mr-1">Filter aktif:</span>

                    @if($currentKategori && $selectedKategori)
                    <a href="{{ route('katalog', array_filter(request()->except('id_kategori'), fn($v) => $v !== '')) }}" class="inline-flex items-center gap-1.5 px-3 py-1 bg-violet-50 text-violet-700 text-xs font-bold rounded-full border border-violet-100 hover:bg-violet-100 transition-colors">
                        {{ $selectedKategori->nama_kategori }}
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </a>
                    @endif

                    @if($currentMinPrice > 0 || $currentMaxPrice < $maxPriceLimit)
                    <a href="{{ route('katalog', array_filter(request()->except(['min_price', 'max_price']), fn($v) => $v !== '')) }}" class="inline-flex items-center gap-1.5 px-3 py-1 bg-violet-50 text-violet-700 text-xs font-bold rounded-full border border-violet-100 hover:bg-violet-100 transition-colors">
                        Rp {{ number_format($currentMinPrice, 0, ',', '.') }} - Rp {{ number_format($currentMaxPrice, 0, ',', '.') }}
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </a>
                    @endif

                    @if($currentSearch)
                    <a href="{{ route('katalog', array_filter(request()->except('search'), fn($v) => $v !== '')) }}" class="inline-flex items-center gap-1.5 px-3 py-1 bg-violet-50 text-violet-700 text-xs font-bold rounded-full border border-violet-100 hover:bg-violet-100 transition-colors">
                        Cari: "{{ $currentSearch }}"
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </a>
                    @endif
                </div>
                @endif

                @if($produks->count() > 0)
                <!-- Product Grid -->
                <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6">
                    @foreach($produks as $produk)
                    <div class="group bg-white rounded-2xl border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 relative flex flex-col">

                        <!-- Badges -->
                        <div class="absolute top-3 left-3 z-10 flex flex-col gap-1">
                            <span class="px-2.5 py-1 bg-white/90 backdrop-blur-sm text-violet-700 text-[10px] uppercase tracking-wider font-bold rounded-lg shadow-sm">
                                {{ $produk->kategori->nama_kategori ?? 'Lainnya' }}
                            </span>
                            @if($produk->created_at->isAfter(now()->subDays(30)))
                            <span class="px-2.5 py-1 bg-pink-500 text-white text-[10px] uppercase tracking-wider font-bold rounded-lg shadow-sm w-fit">Baru</span>
                            @endif
                        </div>

                        <!-- Wishlist -->
                        <button class="absolute top-3 right-3 z-10 w-9 h-9 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center text-gray-400 hover:text-pink-500 hover:bg-pink-50 transition-colors shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        </button>

                        <!-- Image -->
                        <div class="relative w-full aspect-square overflow-hidden bg-gray-100">
                            <img src="{{ $produk->gambar_url }}" alt="{{ $produk->nama_produk }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>

                        <!-- Content -->
                        <div class="p-4 flex flex-col flex-grow">
                            <h3 class="text-gray-800 font-medium leading-tight mb-1 group-hover:text-violet-600 transition-colors line-clamp-2 text-sm sm:text-base">
                                {{ $produk->nama_produk }}
                            </h3>

                            <!-- Rating -->
                            <div class="flex items-center gap-1 mb-3">
                                <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <span class="text-sm font-semibold text-gray-700">{{ round($produk->ratings_avg_rating ?? 0, 1) }}</span>
                                <span class="text-xs text-gray-400">({{ $produk->ratings_count ?? 0 }})</span>
                            </div>

                            <div class="mt-auto flex items-end justify-between">
                                <span class="text-base sm:text-lg font-bold text-violet-600">{{ $produk->harga_format }}</span>
                                <button class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-violet-50 text-violet-600 flex flex-shrink-0 items-center justify-center hover:bg-violet-600 hover:text-white transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                @else
                <!-- Empty State -->
                <div class="text-center py-20 bg-white rounded-2xl border border-gray-100 shadow-sm">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center text-gray-400 mx-auto mb-4">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Produk Tidak Ditemukan</h3>
                    <p class="text-gray-500 font-medium mb-6 max-w-md mx-auto">Maaf, kami tidak dapat menemukan produk yang sesuai dengan kriteria filter Anda.</p>
                    <a href="{{ route('katalog') }}" class="inline-block bg-violet-600 text-white px-6 py-2.5 rounded-full font-bold hover:bg-violet-700 transition-colors shadow-md shadow-violet-500/20">Hapus Semua Filter</a>
                </div>
                @endif

            </section>
        </div>
    </main>

    <!-- ==================== MOBILE FILTER PANEL ==================== -->
    <div id="mobileFilterPanel" class="fixed inset-0 z-50 md:hidden" style="display:none;">
        <div class="absolute inset-0 bg-black/40" onclick="closeMobileFilter()"></div>
        <div class="absolute bottom-0 left-0 right-0 bg-white rounded-t-3xl p-6 max-h-[80vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-bold text-gray-900">Filter</h2>
                <button onclick="closeMobileFilter()" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 text-gray-500 hover:bg-gray-200 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form id="mobileFilterForm" method="GET" action="{{ route('katalog') }}">
                <input type="hidden" name="sort" value="{{ $currentSort }}">

                <div class="mb-8">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Kategori Produk</h3>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('katalog', array_filter(array_merge(request()->all(), ['id_kategori' => '']), fn($v) => $v !== '')) }}" class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 border {{ !$currentKategori ? 'bg-violet-600 text-white border-violet-600 shadow-md shadow-violet-500/20' : 'bg-white text-gray-600 border-gray-200 hover:border-violet-300 hover:text-violet-600' }}">
                            Semua
                        </a>
                        @foreach($kategoris as $kat)
                        <a href="{{ route('katalog', array_filter(array_merge(request()->all(), ['id_kategori' => $kat->id_kategori]), fn($v) => $v !== '')) }}" class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 border {{ $currentKategori == $kat->id_kategori ? 'bg-violet-600 text-white border-violet-600 shadow-md shadow-violet-500/20' : 'bg-white text-gray-600 border-gray-200 hover:border-violet-300 hover:text-violet-600' }}">
                            {{ $kat->nama_kategori }}
                        </a>
                        @endforeach
                    </div>
                </div>

                <hr class="border-gray-100 mb-8">

                <div class="mb-8">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Rentang Harga</h3>
                    <div class="range-slider">
                        <div class="slider-track" id="sliderTrackMobile"></div>
                        <input type="range" id="minRangeMobile" min="0" max="{{ $maxPriceLimit }}" step="10000" value="{{ $currentMinPrice }}">
                        <input type="range" id="maxRangeMobile" min="0" max="{{ $maxPriceLimit }}" step="10000" value="{{ $currentMaxPrice }}">
                    </div>
                    <div class="flex items-center justify-between gap-3 mt-4">
                        <div class="flex-1">
                            <label class="text-[10px] font-bold text-gray-400 uppercase">Min</label>
                            <div class="relative mt-1">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 text-sm font-medium">Rp</span>
                                <input type="number" id="minInputMobile" name="min_price" value="{{ $currentMinPrice }}" min="0" max="{{ $maxPriceLimit }}" step="10000" class="w-full bg-gray-50 border border-gray-200 rounded-lg pl-9 pr-3 py-2 text-sm font-bold text-gray-900 focus:outline-none focus:border-violet-400">
                            </div>
                        </div>
                        <div class="text-gray-400 font-bold mt-5">-</div>
                        <div class="flex-1">
                            <label class="text-[10px] font-bold text-gray-400 uppercase">Max</label>
                            <div class="relative mt-1">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 text-sm font-medium">Rp</span>
                                <input type="number" id="maxInputMobile" name="max_price" value="{{ $currentMaxPrice }}" min="0" max="{{ $maxPriceLimit }}" step="10000" class="w-full bg-gray-50 border border-gray-200 rounded-lg pl-9 pr-3 py-2 text-sm font-bold text-gray-900 focus:outline-none focus:border-violet-400">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('katalog') }}" class="flex-1 py-3 border-2 border-gray-200 text-gray-700 rounded-xl font-bold hover:bg-gray-50 transition-colors text-center">Reset</a>
                    <button type="submit" class="flex-1 py-3 bg-violet-600 text-white rounded-xl font-bold hover:bg-violet-700 transition-colors shadow-md shadow-violet-500/20">Terapkan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ==================== FOOTER ==================== -->
    <footer class="bg-white border-t border-gray-200 pt-16 pb-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
                <div>
                    <a href="{{ route('home') }}" class="text-xl md:text-2xl font-bold flex items-center gap-2 mb-6">
                        <img src="{{ asset('storage/image/logo.png') }}" alt="Logo Pelangi" class="w-8 h-8 md:w-10 md:h-10 object-contain" onerror="this.outerHTML='<div class=\'w-8 h-8 md:w-10 md:h-10 bg-gray-200 rounded-full flex items-center justify-center text-[10px] text-gray-500\'>Logo</div>'">
                        <span class="text-gray-900">Pelangi</span> <span class="text-pink-500">Accessories</span>
                    </a>
                    <p class="text-gray-500 mb-6 text-sm leading-relaxed">Menyediakan berbagai macam aksesoris wanita kekinian dengan desain elegan, kualitas premium, dan harga terjangkau.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-violet-50 flex items-center justify-center text-violet-600 hover:bg-violet-600 hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-violet-50 flex items-center justify-center text-violet-600 hover:bg-violet-600 hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4z"/></svg>
                        </a>
                    </div>
                </div>
                <div>
                    <h4 class="font-bold text-gray-800 mb-6 uppercase text-sm tracking-wider">Kategori</h4>
                    <ul class="space-y-3 text-sm text-gray-500">
                        @foreach($kategoris->take(4) as $kat)
                        <li><a href="{{ route('katalog', ['id_kategori' => $kat->id_kategori]) }}" class="hover:text-violet-600 hover:translate-x-1 inline-block transition-transform">{{ $kat->nama_kategori }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-gray-800 mb-6 uppercase text-sm tracking-wider">Bantuan</h4>
                    <ul class="space-y-3 text-sm text-gray-500">
                        <li><a href="#" class="hover:text-violet-600 hover:translate-x-1 inline-block transition-transform">Cara Pemesanan</a></li>
                        <li><a href="#" class="hover:text-violet-600 hover:translate-x-1 inline-block transition-transform">Konfirmasi Pembayaran</a></li>
                        <li><a href="#" class="hover:text-violet-600 hover:translate-x-1 inline-block transition-transform">Kebijakan Pengembalian</a></li>
                        <li><a href="#" class="hover:text-violet-600 hover:translate-x-1 inline-block transition-transform">FAQ</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-gray-800 mb-6 uppercase text-sm tracking-wider">Kontak Kami</h4>
                    <ul class="space-y-4 text-sm text-gray-500">
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-violet-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>Jl. Melati Indah No. 45, Jakarta Selatan 12345</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-violet-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <span>+62 812 3456 7890</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-violet-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <span>halo@pelangiacc.com</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-100 pt-8 flex flex-col md:flex-row justify-between items-center gap-6">
                <p class="text-sm text-gray-400">&copy; {{ date('Y') }} Pelangi Accessories. Hak Cipta Dilindungi.</p>
                <div class="flex space-x-4 items-center">
                    <span class="text-xs text-gray-400 font-medium">Pembayaran:</span>
                    <span class="text-sm font-bold text-gray-400 border border-gray-200 px-2 py-1 rounded">BCA</span>
                    <span class="text-sm font-bold text-gray-400 border border-gray-200 px-2 py-1 rounded">GoPay</span>
                    <span class="text-sm font-bold text-gray-400 border border-gray-200 px-2 py-1 rounded">OVO</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- ==================== VANILLA JS ==================== -->
    <script>
        // ── Mobile Filter Panel ──
        function openMobileFilter() {
            document.getElementById('mobileFilterPanel').style.display = '';
            document.body.style.overflow = 'hidden';
        }
        function closeMobileFilter() {
            document.getElementById('mobileFilterPanel').style.display = 'none';
            document.body.style.overflow = '';
        }

        // ── Range Slider Sync ──
        function setupRangeSlider(prefix) {
            const minRange = document.getElementById('minRange' + prefix);
            const maxRange = document.getElementById('maxRange' + prefix);
            const minInput = document.getElementById('minInput' + prefix);
            const maxInput = document.getElementById('maxInput' + prefix);
            const track   = document.getElementById('sliderTrack' + prefix);
            const maxLimit = {{ $maxPriceLimit }};

            if (!minRange || !maxRange) return;

            function updateTrack() {
                const minVal = parseInt(minRange.value);
                const maxVal = parseInt(maxRange.value);
                track.style.left  = (minVal / maxLimit * 100) + '%';
                track.style.right = (100 - maxVal / maxLimit * 100) + '%';
            }

            minRange.addEventListener('input', function () {
                if (parseInt(minRange.value) > parseInt(maxRange.value)) {
                    minRange.value = maxRange.value;
                }
                minInput.value = minRange.value;
                updateTrack();
            });

            maxRange.addEventListener('input', function () {
                if (parseInt(maxRange.value) < parseInt(minRange.value)) {
                    maxRange.value = minRange.value;
                }
                maxInput.value = maxRange.value;
                updateTrack();
            });

            minInput.addEventListener('change', function () {
                let val = parseInt(minInput.value) || 0;
                val = Math.max(0, Math.min(val, parseInt(maxRange.value)));
                minInput.value = val;
                minRange.value = val;
                updateTrack();
            });

            maxInput.addEventListener('change', function () {
                let val = parseInt(maxInput.value) || maxLimit;
                val = Math.max(parseInt(minRange.value), Math.min(val, maxLimit));
                maxInput.value = val;
                maxRange.value = val;
                updateTrack();
            });

            updateTrack();
        }

        // ── Clean empty params before submit ──
        document.querySelectorAll('form').forEach(function (form) {
            form.addEventListener('submit', function () {
                this.querySelectorAll('input[name], select[name]').forEach(function (el) {
                    if (el.value === '' || el.value === null) {
                        el.disabled = true;
                    }
                });
            });
        });

        // ── Init ──
        document.addEventListener('DOMContentLoaded', function () {
            setupRangeSlider('Desktop');
            setupRangeSlider('Mobile');
        });
    </script>

</body>
</html>