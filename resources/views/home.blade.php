<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda | Pelangi Accessories</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased selection:bg-violet-200 selection:text-violet-800">

@php
    // ── Data Statis (bukan dari database) ──
    $features = [
        ['title' => 'Kualitas Premium', 'desc' => 'Bahan awet & tahan lama', 'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>'],
        ['title' => 'Garansi 100%', 'desc' => 'Pengembalian 7 hari', 'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>'],
        ['title' => 'Pembayaran Aman', 'desc' => 'Didukung payment gateway', 'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>'],
        ['title' => 'Customer Service', 'desc' => 'Bantuan 24/7 untuk Anda', 'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path></svg>'],
    ];

    $testimonials = [
        ['name' => 'Siti Aminah', 'role' => 'Pelanggan Setia', 'rating' => 5, 'quote' => 'Aksesorisnya lucu-lucu banget dan sesuai ekspektasi. Warnanya pastel gitu, manis banget saat dipakai!', 'avatar' => 'https://randomuser.me/api/portraits/women/12.jpg'],
        ['name' => 'Bunga Citra', 'role' => 'Reseller VIP', 'rating' => 5, 'quote' => 'Jadi reseller di Pelangi Accessories menguntungkan banget. Kualitasnya juara, packaging rapi dan aman.', 'avatar' => 'https://randomuser.me/api/portraits/women/44.jpg'],
        ['name' => 'Dian Sastro', 'role' => 'Pelanggan Baru', 'rating' => 4, 'quote' => 'Pengirimannya super cepat, adminnya sangat responsif. Cincin berlian simulannya kelihatan mahal banget.', 'avatar' => 'https://randomuser.me/api/portraits/women/68.jpg'],
    ];
@endphp

    <!-- 1. NAVBAR -->
    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex-shrink-0 flex items-center mr-8 lg:mr-12">
                    <a href="{{ route('home') }}" class="text-xl md:text-2xl font-bold flex items-center gap-2">
                        <img src="{{ asset('storage/image/logo.png') }}" alt="Logo Pelangi" class="w-8 h-8 md:w-10 md:h-10 object-contain" onerror="this.outerHTML='<div class=\'w-8 h-8 md:w-10 md:h-10 bg-gray-200 rounded-full flex items-center justify-center text-[10px] text-gray-500 font-normal\'>Logo</div>'">
                        <span class="text-gray-900">Pelangi</span> <span class="text-pink-500">Accessories</span>
                    </a>
                </div>

                <div class="hidden md:flex space-x-8">
                    <a href="{{ route('home') }}" class="text-violet-600 font-medium">Beranda</a>
                    <a href="{{ route('katalog') }}" class="text-gray-500 hover:text-violet-600 transition-colors">Katalog</a>
                    <a href="{{ route('about') }}" class="text-gray-500 hover:text-violet-600 transition-colors">Tentang Kami</a>
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
                    <a href="{{ route('keranjang.index') }}" class="relative text-gray-500 hover:text-violet-600 transition-colors" id="navCartBtn">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <span id="navCartBadge" class="{{ $cartCount > 0 ? '' : 'hidden' }} absolute -top-2 -right-2 w-5 h-5 bg-pink-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center shadow-sm">{{ $cartCount > 99 ? '99+' : $cartCount }}</span>
                    </a>

                    @auth
                    @php $userName = auth()->user()->name ?? auth()->user()->nama ?? 'Pelanggan'; @endphp
                    <div class="hidden sm:flex items-center space-x-4">
                        <a href="/dashboard" class="text-violet-600 hover:text-pink-400 font-medium transition-colors">
                            {{ $userName }}
                        </a>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-home').submit();" class="text-gray-400 hover:text-red-500 font-medium transition-colors text-sm">
                            Keluar
                        </a>
                        <form id="logout-home" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
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

    <!-- 2. HERO SECTION -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="relative rounded-2xl overflow-hidden shadow-sm h-[420px] md:h-[520px]">
            <img src="https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80" alt="Hero Background" class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-violet-700/70 via-violet-500/40 to-pink-400/40"></div>
            <div class="absolute inset-0 bg-black/10"></div>
            <div class="relative z-10 flex flex-col justify-center h-full px-6 md:px-16 lg:w-2/3">
                <span class="text-white/90 uppercase tracking-widest text-xs md:text-sm font-semibold mb-4">Koleksi Terbaru {{ date('Y') }}</span>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white leading-tight mb-6">Tampil Elegan dengan <br> Aksesoris Pilihan</h1>
                <p class="text-base md:text-lg text-white/90 mb-8 max-w-xl">Lengkapi gaya harianmu dengan sentuhan aksesoris bernuansa soft pastel yang cantik, modern, dan penuh pesona.</p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('katalog') }}" class="bg-white text-violet-600 px-8 py-3 rounded-full font-semibold hover:shadow-lg hover:scale-105 transition duration-300">Belanja Sekarang</a>
                    <a href="{{ route('katalog') }}" class="border border-white text-white px-8 py-3 rounded-full font-semibold hover:bg-white/20 hover:scale-105 transition duration-300">Lihat Promo</a>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. KATEGORI (DINAMIS dari database) -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Kategori Pilihan</h2>
                    <p class="text-gray-500 mt-2">Temukan aksesoris yang paling cocok untuk gayamu</p>
                </div>
                <a href="{{ route('katalog') }}" class="hidden sm:block text-violet-600 font-medium hover:text-pink-400 transition-colors">Lihat Semua &rarr;</a>
            </div>

            @if($kategoris->count())
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                @foreach($kategoris as $kategori)
                <a href="{{ route('katalog', ['id_kategori' => $kategori->id_kategori]) }}" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col items-center justify-center gap-4 hover:shadow-lg hover:-translate-y-1 hover:border-violet-200 transition-all group">
                    <div class="w-20 h-20 overflow-hidden rounded-full border-4 border-violet-50 group-hover:border-violet-200 transition-colors duration-300">
                        <img src="{{ $kategori->gambar_url }}" alt="{{ $kategori->nama_kategori }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <span class="text-gray-600 font-medium group-hover:text-violet-600 transition-colors text-center">{{ $kategori->nama_kategori }}</span>
                </a>
                @endforeach
            </div>
            @else
            <p class="text-center text-gray-400 py-8">Belum ada kategori.</p>
            @endif
        </div>
    </section>

    <!-- 4. PRODUK TERBARU (DINAMIS dari database) -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800">Produk Terbaru</h2>
                <p class="text-gray-500 mt-3">Koleksi aksesoris paling laris dan hits minggu ini</p>
            </div>

            @if($produks->count())
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($produks as $produk)

                {{-- ✅ DIUBAH: <div> menjadi <a> agar kartu bisa diklik ke detail --}}
                <a href="{{ route('produk.detail', $produk->id_produk) }}" class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg hover:scale-105 transition-all duration-300 group relative flex flex-col">

                    {{-- ✅ DIUBAH: Wishlist diberi preventDefault + stopPropagation --}}
                    <button onclick="event.preventDefault(); event.stopPropagation();" class="absolute top-3 right-3 z-10 w-8 h-8 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center text-gray-400 hover:text-pink-400 hover:bg-pink-50 transition-colors shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </button>

                    @if($produk->created_at->isAfter(now()->subDays(30)))
                    <span class="absolute top-3 left-3 z-10 px-2.5 py-1 bg-pink-500 text-white text-[10px] uppercase tracking-wider font-bold rounded-lg shadow-sm">Baru</span>
                    @endif

                    <div class="relative w-full aspect-square overflow-hidden bg-gray-50">
                        <img src="{{ $produk->gambar_url }}" alt="{{ $produk->nama_produk }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>

                    <div class="p-4 flex flex-col flex-grow">
                        <span class="inline-block px-2.5 py-1 bg-violet-100 text-violet-600 text-[11px] font-semibold rounded-md mb-2 w-max">
                            {{ $produk->kategori->nama_kategori ?? 'Lainnya' }}
                        </span>
                        <h3 class="text-gray-800 font-medium leading-tight mb-2 line-clamp-2 group-hover:text-violet-600 transition-colors">{{ $produk->nama_produk }}</h3>

                        {{-- Rating --}}
                        @if($produk->ratings_count > 0)
                        <div class="flex items-center gap-1 mb-2">
                            <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <span class="text-sm font-semibold text-gray-700">{{ round($produk->ratings_avg_rating, 1) }}</span>
                            <span class="text-xs text-gray-400">({{ $produk->ratings_count }})</span>
                        </div>
                        @endif

                        {{-- ✅ DIUBAH: Harga + tombol plus sejajar seperti katalog --}}
                        <div class="mt-auto flex items-end justify-between gap-2">
                            @php $isReseller = auth()->check() && auth()->user()->role === 'reseller' && $produk->harga_reseller && $produk->harga_reseller > 0; @endphp
                            <div class="flex flex-col">
                                <span class="text-lg font-bold {{ $isReseller ? 'text-emerald-600' : 'text-violet-600' }}">{{ $produk->harga_format }}</span>
                                @if($isReseller)
                                <span class="text-xs text-gray-400 line-through">{{ $produk->harga_regular_format }}</span>
                                @endif
                            </div>

                            {{-- ✅ DIUBAH: Tombol teks diganti ikon plus bulat --}}
                            <button onclick="event.preventDefault(); event.stopPropagation(); addToCartFromHome({{ $produk->id_produk }})" class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-violet-50 text-violet-600 flex flex-shrink-0 items-center justify-center hover:bg-violet-600 hover:text-white transition-colors" title="Tambah ke Keranjang">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            </button>
                        </div>
                    </div>

                {{-- ✅ DIUBAH: penutup </div> menjadi </a> --}}
                </a>

                @endforeach
            </div>
            @else
            <p class="text-center text-gray-400 py-12">Belum ada produk.</p>
            @endif

            <div class="text-center mt-12">
                <a href="{{ route('katalog') }}" class="inline-block border-2 border-violet-600 text-violet-600 px-8 py-3 rounded-full font-semibold hover:bg-violet-600 hover:text-white transition-colors">Lihat Semua Produk</a>
            </div>
        </div>
    </section>

    <!-- 5. KEUNGGULAN -->
    <section class="py-12 bg-violet-50 border-y border-violet-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($features as $feature)
                <div class="flex items-center gap-4 group">
                    <div class="w-14 h-14 bg-white rounded-full flex items-center justify-center text-violet-600 shadow-sm flex-shrink-0 group-hover:scale-110 group-hover:bg-violet-600 group-hover:text-white transition-all duration-300">
                        {!! $feature['icon'] !!}
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800">{{ $feature['title'] }}</h4>
                        <p class="text-sm text-gray-500">{{ $feature['desc'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 6. CTA RESELLER -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="rounded-2xl bg-gradient-to-r from-pink-400 to-orange-300 p-8 md:p-12 shadow-lg relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-8">
                <div class="absolute -top-24 -right-24 w-64 h-64 bg-white opacity-20 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-white opacity-20 rounded-full blur-3xl"></div>
                <div class="relative z-10 md:w-2/3 text-center md:text-left">
                    <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Bergabung Menjadi Reseller Kami!</h2>
                    <p class="text-white/90 text-lg mb-8 max-w-xl mx-auto md:mx-0">Dapatkan harga khusus, materi promosi eksklusif, dan mulai bangun bisnis aksesorismu sendiri bersama Pelangi Accessories.</p>

                    @auth
                        @if(auth()->user()->role === 'reseller')
                            <a href="{{ route('reseller.dashboard') }}" class="inline-block bg-gray-900 text-white px-8 py-4 rounded-full font-semibold hover:bg-gray-800 hover:scale-105 hover:shadow-xl transition-all">
                                Dashboard Reseller
                            </a>
                        @else
                            <a href="{{ route('reseller.register.form') }}" class="inline-block bg-gray-900 text-white px-8 py-4 rounded-full font-semibold hover:bg-gray-800 hover:scale-105 hover:shadow-xl transition-all">
                                Daftar Sekarang
                            </a>
                        @endif
                    @endauth

                    @guest
                        <a href="{{ route('login') }}" class="inline-block bg-gray-900 text-white px-8 py-4 rounded-full font-semibold hover:bg-gray-800 hover:scale-105 hover:shadow-xl transition-all">
                            Daftar Sekarang
                        </a>
                        <p class="text-white/80 text-sm mt-3">*Anda harus login terlebih dahulu untuk mendaftar</p>
                    @endguest
                </div>
                <div class="relative z-10 md:w-1/3 flex justify-center md:justify-end">
                    <div class="bg-white rounded-xl p-8 text-center shadow-lg transform rotate-2 hover:rotate-0 hover:scale-105 transition-all duration-300 w-full max-w-sm">
                        <span class="block text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-pink-400 to-orange-300 mb-2">200+</span>
                        <span class="text-gray-600 font-medium">Reseller telah bergabung dan sukses di seluruh Indonesia</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 7. TESTIMONI -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800">Apa Kata Mereka?</h2>
                <p class="text-gray-500 mt-3">Pengalaman berbelanja di Pelangi Accessories</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($testimonials as $testi)
                <div class="bg-white rounded-xl p-8 shadow-sm hover:shadow-lg transition-shadow duration-300 border border-gray-100 flex flex-col h-full">
                    <div class="flex text-yellow-400 mb-4">
                        @for($i = 0; $i < $testi['rating']; $i++)
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                    <p class="text-gray-600 italic mb-8 flex-grow">"{{ $testi['quote'] }}"</p>
                    <div class="flex items-center gap-4">
                        <img src="{{ $testi['avatar'] }}" alt="{{ $testi['name'] }}" class="w-12 h-12 rounded-full object-cover border-2 border-violet-100">
                        <div>
                            <h4 class="font-bold text-gray-800">{{ $testi['name'] }}</h4>
                            <p class="text-sm text-pink-400 font-medium">{{ $testi['role'] }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 8. FOOTER -->
    <footer class="bg-white border-t border-gray-200 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
                <div>
                    <a href="{{ route('home') }}" class="text-xl md:text-2xl font-bold flex items-center gap-2 mb-6">
                        <img src="{{ asset('storage/image/logo.png') }}" alt="Logo Pelangi" class="w-8 h-8 md:w-10 md:h-10 object-contain" onerror="this.outerHTML='<div class=\'w-8 h-8 md:w-10 md:h-10 bg-gray-200 rounded-full flex items-center justify-center text-[10px] text-gray-500 font-normal\'>Logo</div>'">
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

    <script>
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            || document.querySelector('input[name="_token"]')?.value;

        let toastTimeout;
        function showToast(message, type = 'success') {
            let toast = document.getElementById('homeToast');
            if (!toast) {
                toast = document.createElement('div');
                toast.id = 'homeToast';
                toast.className = 'fixed top-6 right-6 z-[100] transform translate-x-[120%] transition-transform duration-300 ease-out';
                toast.innerHTML = `
                    <div class="bg-white border border-gray-200 shadow-2xl rounded-xl px-5 py-4 flex items-center gap-3 max-w-sm">
                        <div id="homeToastIcon" class="flex-shrink-0"></div>
                        <p id="homeToastMsg" class="text-sm font-medium text-gray-700"></p>
                    </div>`;
                document.body.appendChild(toast);
            }
            const iconEl = document.getElementById('homeToastIcon');
            const msgEl  = document.getElementById('homeToastMsg');
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

        function addToCartFromHome(produkId) {
            @guest
            showToast('Silakan login terlebih dahulu.', 'info');
            setTimeout(() => { window.location.href = '{{ route("login") }}'; }, 1500);
            return;
            @endguest

            fetch('{{ route("keranjang.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    id_produk: produkId,
                    kuantitas: 1,
                    id_varian: null,
                }),
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    showToast(data.message, 'success');
                    updateCartBadge(data.total_items);
                } else {
                    showToast(data.message || 'Gagal.', 'error');
                }
            })
            .catch(() => showToast('Terjadi kesalahan.', 'error'));
        }
    </script>
</body>
</html>