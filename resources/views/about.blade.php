<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami | Pelangi Accessories</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #d1d5db; }

        .gradient-text {
            background: linear-gradient(135deg, #7c3aed, #ec4899);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body class="bg-white text-gray-800 font-sans antialiased selection:bg-violet-200 selection:text-violet-800">

    <!-- NAVBAR -->
    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex-shrink-0 flex items-center mr-8 lg:mr-12">
                    <a href="/" class="text-xl md:text-2xl font-bold flex items-center gap-2">
                        <img src="{{ asset('storage/image/logo.png') }}" alt="Logo Pelangi" class="w-8 h-8 md:w-10 md:h-10 object-contain">
                        <span class="text-gray-900">Pelangi</span> <span class="text-pink-500">Accessories</span>
                    </a>
                </div>

                <div class="hidden md:flex space-x-8">
                    <a href="/" class="text-gray-500 hover:text-violet-600 transition-colors font-medium">Beranda</a>
                    <a href="/katalog" class="text-gray-500 hover:text-violet-600 transition-colors font-medium">Katalog</a>
                    <a href="/about" class="text-violet-600 font-semibold relative">
                        Tentang Kami
                        <span class="absolute -bottom-1.5 left-0 w-full h-0.5 bg-violet-600 rounded-full"></span>
                    </a>
                    <!-- <a href="#" class="text-gray-500 hover:text-violet-600 transition-colors font-medium">Kontak</a> -->
                </div>

                <div class="hidden lg:flex flex-1 max-w-md mx-8">
                    <div class="relative w-full">
                        <input type="text" placeholder="Cari aksesoris..." class="w-full bg-gray-100 rounded-full py-2.5 pl-5 pr-10 text-sm focus:outline-none focus:ring-2 focus:ring-violet-300 focus:bg-white border border-transparent focus:border-violet-300 transition-all">
                        <button class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-violet-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </button>
                    </div>
                </div>

                <div class="flex items-center space-x-6">
                    <button class="relative text-gray-500 hover:text-violet-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <span class="absolute -top-2 -right-2 bg-violet-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full border border-white">3</span>
                    </button>
                    <div class="hidden sm:flex items-center space-x-4">
                        <a href="/login" class="text-gray-500 hover:text-violet-600 font-medium transition-colors">Masuk</a>
                        <a href="/register" class="bg-gradient-to-r from-violet-600 to-pink-400 text-white px-6 py-2.5 rounded-full font-medium hover:shadow-lg hover:scale-105 transition-all">Daftar</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="relative overflow-hidden bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-20 lg:py-24">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 items-center">
                
                <!-- Image Side -->
                <div class="relative order-1 flex justify-center lg:justify-start">
                    <div class="relative w-full max-w-lg">
                        <div class="relative rounded-2xl overflow-hidden shadow-2xl">
                            <img src="https://picsum.photos/seed/pelangi-tradisi/700/900.jpg" alt="Tradisi Pelangi Accessories" class="w-full h-[420px] md:h-[520px] lg:h-[580px] object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-6 md:p-8">
                                <span class="inline-flex items-center gap-2 px-4 py-2 bg-white/20 backdrop-blur-md text-white text-xs font-bold uppercase tracking-widest rounded-full mb-3 border border-white/30">
                                    <iconify-icon icon="lucide:sparkles" class="text-sm"></iconify-icon>
                                    Since 2019
                                </span>
                                <p class="text-white/90 text-sm font-medium">Riau, Indonesia</p>
                            </div>
                        </div>
                        
                        <!-- Floating badge -->
                        <div class="absolute -bottom-4 -right-4 md:bottom-6 md:-right-6 bg-white rounded-2xl shadow-xl p-4 flex items-center gap-3 border border-gray-100">
                            <div class="w-11 h-11 bg-violet-100 rounded-xl flex items-center justify-center">
                                <iconify-icon icon="lucide:globe" class="text-violet-600 text-xl"></iconify-icon>
                            </div>
                            <div>
                                <span class="block text-sm font-bold text-gray-900">100% Digital</span>
                                <span class="block text-xs text-gray-500">Fokus Online</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Text Side -->
                <div class="relative z-10 order-2">
                    <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 leading-tight mb-6">
                        Transformasi <br>
                        <span class="gradient-text">Tradisi</span> Menuju <br>
                        <span class="gradient-text">Era Digital</span>
                    </h1>
                    
                    <p class="text-base md:text-lg text-gray-500 leading-relaxed mb-8 max-w-lg">
                        Dari toko kecil di Riau yang penuh mimpi, kini Pelangi Accessories hadir sebagai destinasi digital aksesoris wanita terpercaya di seluruh Indonesia.
                    </p>

                    <a href="/katalog" class="inline-flex items-center gap-2 bg-gradient-to-r from-violet-600 to-pink-400 text-white px-8 py-3.5 rounded-full font-semibold hover:shadow-xl hover:shadow-violet-500/25 hover:scale-105 transition-all duration-300">
                        Belanja Sekarang
                        <iconify-icon icon="lucide:arrow-right" class="text-lg"></iconify-icon>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- CERITA KAMI -->
    <section id="cerita" class="py-16 md:py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-start">
                
                <div>
                    <span class="inline-flex items-center gap-2 px-4 py-2 bg-violet-50 text-violet-600 text-xs font-bold uppercase tracking-widest rounded-full mb-6 border border-violet-100">
                        <iconify-icon icon="lucide:book-open" class="text-sm"></iconify-icon>
                        Cerita Kami
                    </span>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6 leading-tight">
                        Cerita Pelangi <span class="gradient-text">Accessories</span>
                    </h2>
                    <p class="text-gray-500 text-base leading-relaxed mb-8">
                        Dari sebuah toko kecil di Riau hingga menjadi brand aksesoris digital yang dipercaya ribuan pelanggan di seluruh Indonesia. Perjalanan kami penuh semangat dan transformasi.
                    </p>

                    <div class="space-y-5">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-violet-600 rounded-xl flex items-center justify-center text-white shadow-md shadow-violet-200">
                                <iconify-icon icon="lucide:rocket" class="text-xl"></iconify-icon>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 mb-1">2019 — Didirikan di Riau</h4>
                                <p class="text-gray-500 text-sm leading-relaxed">Pelangi Accessories lahir dari passion terhadap aksesoris wanita. Dimulai dari toko kecil dengan modal terbatas namun mimpi yang besar.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-pink-500 rounded-xl flex items-center justify-center text-white shadow-md shadow-pink-200">
                                <iconify-icon icon="lucide:globe" class="text-xl"></iconify-icon>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 mb-1">2020 — Transisi ke E-Commerce</h4>
                                <p class="text-gray-500 text-sm leading-relaxed">Pandemi mengubah segalanya. Kami berani mengambil langkah membawa bisnis ke dunia digital dan marketplace.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-violet-600 rounded-xl flex items-center justify-center text-white shadow-md shadow-violet-200">
                                <iconify-icon icon="lucide:zap" class="text-xl"></iconify-icon>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 mb-1">100% Digital & Fokus Online</h4>
                                <p class="text-gray-500 text-sm leading-relaxed">Seluruh operasional bisnis kini berjalan secara digital — dari inventori, pemesanan, hingga pengiriman terintegrasi sempurna.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- MISI KAMI -->
                <div>
                    <span class="inline-flex items-center gap-2 px-4 py-2 bg-pink-50 text-pink-600 text-xs font-bold uppercase tracking-widest rounded-full mb-6 border border-pink-100">
                        <iconify-icon icon="lucide:target" class="text-sm"></iconify-icon>
                        Misi Kami
                    </span>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6 leading-tight">
                        Misi <span class="gradient-text">Kami</span>
                    </h2>
                    <p class="text-gray-500 text-base leading-relaxed mb-8">
                        Brand aksesoris yang menjual produk melalui platform digital, menjangkau pelanggan di seluruh Indonesia dengan pengalaman belanja yang menyenangkan.
                    </p>

                    <div class="space-y-4">
                        <div class="flex items-start gap-4 group bg-white rounded-xl p-5 border border-gray-100 hover:shadow-md hover:border-violet-100 transition-all duration-300">
                            <div class="w-11 h-11 flex-shrink-0 bg-violet-50 rounded-xl flex items-center justify-center text-violet-600 group-hover:bg-violet-600 group-hover:text-white transition-colors duration-300">
                                <iconify-icon icon="lucide:palette" class="text-lg"></iconify-icon>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 mb-1 group-hover:text-violet-600 transition-colors">Desain Elegan & Kekinian</h4>
                                <p class="text-gray-500 text-sm leading-relaxed">Menghadirkan koleksi aksesoris yang selalu mengikuti tren fashion terbaru.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4 group bg-white rounded-xl p-5 border border-gray-100 hover:shadow-md hover:border-violet-100 transition-all duration-300">
                            <div class="w-11 h-11 flex-shrink-0 bg-pink-50 rounded-xl flex items-center justify-center text-pink-500 group-hover:bg-pink-500 group-hover:text-white transition-colors duration-300">
                                <iconify-icon icon="lucide:shield-check" class="text-lg"></iconify-icon>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 mb-1 group-hover:text-pink-500 transition-colors">Kualitas Tanpa Kompromi</h4>
                                <p class="text-gray-500 text-sm leading-relaxed">Setiap produk melewati quality control ketat untuk memastikan yang terbaik.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4 group bg-white rounded-xl p-5 border border-gray-100 hover:shadow-md hover:border-violet-100 transition-all duration-300">
                            <div class="w-11 h-11 flex-shrink-0 bg-violet-50 rounded-xl flex items-center justify-center text-violet-600 group-hover:bg-violet-600 group-hover:text-white transition-colors duration-300">
                                <iconify-icon icon="lucide:heart-handshake" class="text-lg"></iconify-icon>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 mb-1 group-hover:text-violet-600 transition-colors">Harga Terjangkau</h4>
                                <p class="text-gray-500 text-sm leading-relaxed">Keseimbangan antara kualitas premium dan harga yang ramah di kantong.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4 group bg-white rounded-xl p-5 border border-gray-100 hover:shadow-md hover:border-violet-100 transition-all duration-300">
                            <div class="w-11 h-11 flex-shrink-0 bg-pink-50 rounded-xl flex items-center justify-center text-pink-500 group-hover:bg-pink-500 group-hover:text-white transition-colors duration-300">
                                <iconify-icon icon="lucide:users" class="text-lg"></iconify-icon>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 mb-1 group-hover:text-pink-500 transition-colors">Pemberdayaan Reseller</h4>
                                <p class="text-gray-500 text-sm leading-relaxed">Membuka peluang bisnis bagi reseller di seluruh Indonesia secara transparan.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-white border-t border-gray-200 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
                <div>
                    <a href="/" class="text-xl md:text-2xl font-bold flex items-center gap-2 mb-6">
                        <img src="{{ asset('storage/image/logo.png') }}" alt="Logo Pelangi" class="w-8 h-8 md:w-10 md:h-10 object-contain">
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
                        <li><a href="#" class="hover:text-violet-600 hover:translate-x-1 inline-block transition-transform">Kalung & Liontin</a></li>
                        <li><a href="#" class="hover:text-violet-600 hover:translate-x-1 inline-block transition-transform">Cincin & Gelang</a></li>
                        <li><a href="#" class="hover:text-violet-600 hover:translate-x-1 inline-block transition-transform">Anting & Tusuk</a></li>
                        <li><a href="#" class="hover:text-violet-600 hover:translate-x-1 inline-block transition-transform">Aksesoris Rambut</a></li>
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

</body>
</html>