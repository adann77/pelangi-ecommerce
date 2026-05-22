<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | Pelangi Accessories</title>
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

        /* Custom Styling for Radio Buttons */
        .radio-card input[type="radio"]:checked + label {
            border-color: #8b5cf6; /* violet-500 */
            background-color: #f5f3ff; /* violet-50 */
            color: #7c3aed;
        }
        .radio-card input[type="radio"]:checked + label .radio-dot {
            background-color: #8b5cf6;
            box-shadow: 0 0 0 3px white, 0 0 0 5px #8b5cf6;
        }
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
                <div class="flex items-center space-x-6">
                    <a href="{{ route('keranjang.index') }}" class="relative text-gray-400 hover:text-violet-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </a>
                    @auth
                    <div class="hidden sm:flex items-center space-x-4">
                        <a href="/dashboard" class="text-violet-600 hover:text-pink-400 font-medium transition-colors">{{ auth()->user()->name }}</a>
                        <form id="logout-checkout" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
                    </div>
                    @endauth
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
                <li><a href="{{ route('keranjang.index') }}" class="hover:text-violet-600 transition-colors">Keranjang</a></li>
                <li><svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></li>
                <li><span class="text-gray-900">Checkout</span></li>
            </ol>
        </nav>

        <form action="{{ route('checkout.process') }}" method="POST" id="checkoutForm">
            @csrf
            
            <div class="flex flex-col lg:flex-row gap-8 items-start">

                {{-- ══════════════════════════════════════
                     LEFT: Form Inputs
                     ══════════════════════════════════════ --}}
                <div class="flex-1 w-full space-y-6">

                    {{-- Alamat Pengiriman --}}
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                        <h2 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Alamat Pengiriman
                        </h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Penerima <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_penerima" value="{{ auth()->user()->name ?? '' }}" required class="w-full bg-gray-50 border border-gray-200 rounded-xl py-2.5 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-violet-300 focus:border-violet-300 focus:bg-white transition-all" placeholder="Nama lengkap">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">No. Telepon <span class="text-red-500">*</span></label>
                                <input type="tel" name="no_telepon" required class="w-full bg-gray-50 border border-gray-200 rounded-xl py-2.5 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-violet-300 focus:border-violet-300 focus:bg-white transition-all" placeholder="08xxxxxxxxxx">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap <span class="text-red-500">*</span></label>
                                <textarea name="alamat_lengkap" rows="3" required class="w-full bg-gray-50 border border-gray-200 rounded-xl py-2.5 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-violet-300 focus:border-violet-300 focus:bg-white transition-all resize-none" placeholder="Nama jalan, nomor rumah, RT/RW, Kelurahan, Kecamatan"></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kota <span class="text-red-500">*</span></label>
                                <input type="text" name="kota" required class="w-full bg-gray-50 border border-gray-200 rounded-xl py-2.5 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-violet-300 focus:border-violet-300 focus:bg-white transition-all" placeholder="Kota / Kabupaten">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kode Pos <span class="text-red-500">*</span></label>
                                <input type="text" name="kode_pos" required class="w-full bg-gray-50 border border-gray-200 rounded-xl py-2.5 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-violet-300 focus:border-violet-300 focus:bg-white transition-all" placeholder="Kode pos">
                            </div>
                        </div>
                    </div>

                    {{-- Pilih Kurir --}}
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                        <h2 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path></svg>
                            Pilih Kurir Pengiriman
                        </h2>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div class="radio-card">
                                <input type="radio" name="kurir" value="JNE" class="hidden" required checked>
                                <label class="border-2 border-gray-200 rounded-xl p-4 flex items-center justify-between cursor-pointer transition-all hover:border-violet-300">
                                    <div>
                                        <p class="font-bold text-gray-800">JNE</p>
                                        <p class="text-xs text-gray-500 mt-1">Estimasi 2-3 hari</p>
                                    </div>
                                    <div class="radio-dot w-4 h-4 rounded-full bg-gray-200 border-2 border-white transition-all"></div>
                                </label>
                            </div>
                            <div class="radio-card">
                                <input type="radio" name="kurir" value="J&T" class="hidden">
                                <label class="border-2 border-gray-200 rounded-xl p-4 flex items-center justify-between cursor-pointer transition-all hover:border-violet-300">
                                    <div>
                                        <p class="font-bold text-gray-800">J&T</p>
                                        <p class="text-xs text-gray-500 mt-1">Estimasi 2-4 hari</p>
                                    </div>
                                    <div class="radio-dot w-4 h-4 rounded-full bg-gray-200 border-2 border-white transition-all"></div>
                                </label>
                            </div>
                            <div class="radio-card">
                                <input type="radio" name="kurir" value="SiCepat" class="hidden">
                                <label class="border-2 border-gray-200 rounded-xl p-4 flex items-center justify-between cursor-pointer transition-all hover:border-violet-300">
                                    <div>
                                        <p class="font-bold text-gray-800">SiCepat</p>
                                        <p class="text-xs text-gray-500 mt-1">Estimasi 1-2 hari</p>
                                    </div>
                                    <div class="radio-dot w-4 h-4 rounded-full bg-gray-200 border-2 border-white transition-all"></div>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Metode Pembayaran --}}
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                        <h2 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                            Metode Pembayaran
                        </h2>

                        <div class="space-y-6">
                            {{-- Virtual Account --}}
                            <div>
                                <p class="text-sm font-semibold text-gray-500 mb-3">Virtual Account / Transfer Bank</p>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                    <div class="radio-card">
                                        <input type="radio" name="metode_pembayaran" value="BCA" class="hidden" required>
                                        <label class="border-2 border-gray-200 rounded-xl p-4 flex items-center gap-3 cursor-pointer transition-all hover:border-violet-300">
                                            <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center text-blue-600 font-bold text-xs">BCA</div>
                                            <div>
                                                <p class="text-sm font-bold text-gray-800">BCA</p>
                                                <p class="text-[10px] text-gray-500">Virtual Account</p>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="radio-card">
                                        <input type="radio" name="metode_pembayaran" value="BRI" class="hidden">
                                        <label class="border-2 border-gray-200 rounded-xl p-4 flex items-center gap-3 cursor-pointer transition-all hover:border-violet-300">
                                            <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center text-blue-900 font-bold text-xs">BRI</div>
                                            <div>
                                                <p class="text-sm font-bold text-gray-800">BRI</p>
                                                <p class="text-[10px] text-gray-500">Virtual Account</p>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="radio-card">
                                        <input type="radio" name="metode_pembayaran" value="Mandiri" class="hidden">
                                        <label class="border-2 border-gray-200 rounded-xl p-4 flex items-center gap-3 cursor-pointer transition-all hover:border-violet-300">
                                            <div class="w-10 h-10 bg-yellow-50 rounded-lg flex items-center justify-center text-yellow-700 font-bold text-[10px]">MDR</div>
                                            <div>
                                                <p class="text-sm font-bold text-gray-800">Mandiri</p>
                                                <p class="text-[10px] text-gray-500">Virtual Account</p>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            {{-- E-Wallet --}}
                            <div>
                                <p class="text-sm font-semibold text-gray-500 mb-3">E-Wallet (Dompet Digital)</p>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                    <div class="radio-card">
                                        <input type="radio" name="metode_pembayaran" value="GoPay" class="hidden">
                                        <label class="border-2 border-gray-200 rounded-xl p-4 flex items-center gap-3 cursor-pointer transition-all hover:border-violet-300">
                                            <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center text-green-600 font-bold text-xs">GP</div>
                                            <div>
                                                <p class="text-sm font-bold text-gray-800">GoPay</p>
                                                <p class="text-[10px] text-gray-500">E-Wallet</p>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="radio-card">
                                        <input type="radio" name="metode_pembayaran" value="OVO" class="hidden">
                                        <label class="border-2 border-gray-200 rounded-xl p-4 flex items-center gap-3 cursor-pointer transition-all hover:border-violet-300">
                                            <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center text-purple-600 font-bold text-xs">OVO</div>
                                            <div>
                                                <p class="text-sm font-bold text-gray-800">OVO</p>
                                                <p class="text-[10px] text-gray-500">E-Wallet</p>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="radio-card">
                                        <input type="radio" name="metode_pembayaran" value="DANA" class="hidden">
                                        <label class="border-2 border-gray-200 rounded-xl p-4 flex items-center gap-3 cursor-pointer transition-all hover:border-violet-300">
                                            <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center text-blue-500 font-bold text-xs">DANA</div>
                                            <div>
                                                <p class="text-sm font-bold text-gray-800">DANA</p>
                                                <p class="text-[10px] text-gray-500">E-Wallet</p>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- ══════════════════════════════════════
                     RIGHT: Order Summary
                     ══════════════════════════════════════ --}}
                <div class="w-full lg:w-80 xl:w-96 flex-shrink-0 lg:sticky lg:top-28">
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">

                        <h2 class="text-lg font-bold text-gray-900 mb-6">Ringkasan Pesanan</h2>

                        {{-- List Item --}}
                        <div class="space-y-4 max-h-72 overflow-y-auto pr-2 mb-6 border-b border-gray-100 pb-4">
                            @foreach($keranjang->details as $detail)
                            @php
                                $produk = $detail->produk;
                                $varian = $detail->varian;
                                $gambar = $varian && $varian->gambar_varian_url ? $varian->gambar_varian_url : ($produk ? $produk->gambar_url : asset('images/no-image.png'));
                            @endphp
                            <div class="flex gap-3">
                                <div class="w-16 h-16 rounded-lg overflow-hidden bg-gray-100 border border-gray-100 flex-shrink-0">
                                    <img src="{{ $gambar }}" alt="{{ $produk->nama_produk ?? 'Produk' }}" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $produk->nama_produk ?? 'Produk' }}</p>
                                    @if($varian)<p class="text-xs text-violet-500">{{ $varian->nama_varian }}</p>@endif
                                    <p class="text-xs text-gray-500 mt-1">{{ $detail->kuantitas }}x {{ $produk->harga_format ?? '' }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500">Subtotal ({{ $keranjang->total_items ?? 0 }} produk)</span>
                                <span class="font-semibold text-gray-700" id="summarySubtotal">Rp {{ number_format($keranjang->total_harga ?? 0, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500">Ongkos Kirim</span>
                                <span class="font-semibold text-gray-700" id="shippingCostDisplay">Rp 15.000</span>
                                <input type="hidden" name="ongkir" value="15000" id="shippingCostInput">
                            </div>
                        </div>

                        <hr class="my-5 border-gray-100">

                        <div class="flex justify-between items-center mb-6">
                            <span class="text-base font-bold text-gray-900">Total</span>
                            <span class="text-xl font-extrabold text-violet-600" id="summaryTotal">Rp {{ number_format(($keranjang->total_harga ?? 0) + 15000, 0, ',', '.') }}</span>
                        </div>

                        <button type="submit" class="w-full py-3.5 bg-gradient-to-r from-violet-600 to-pink-500 text-white rounded-xl font-bold hover:shadow-lg hover:scale-[1.02] transition-all shadow-md shadow-violet-500/20 text-sm">
                            Bayar Sekarang
                        </button>

                        <a href="{{ route('keranjang.index') }}" class="block text-center mt-4 text-sm font-semibold text-violet-600 hover:text-violet-700 transition-colors">
                            ← Kembali ke Keranjang
                        </a>

                        {{-- Trust badges --}}
                        <div class="mt-6 pt-5 border-t border-gray-100 space-y-3">
                            <div class="flex items-center gap-3 text-xs text-gray-400">
                                <svg class="w-5 h-5 text-emerald-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                <span>Pembayaran 100% Aman</span>
                            </div>
                            <div class="flex items-center gap-3 text-xs text-gray-400">
                                <svg class="w-5 h-5 text-emerald-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                <span>Data Pribadi Terjamin Rahasia</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>

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

    <!-- ==================== JAVASCRIPT ==================== -->
    <script>
        // Format Currency Helper
        const formatRupiah = (angka) => 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');

        // Base Subtotal from PHP
        const baseSubtotal = {{ $keranjang->total_harga ?? 0 }};

        // Define Ongkir per Kurir
        const ongkirMapping = {
            'JNE': 15000,
            'J&T': 18000,
            'SiCepat': 17000
        };

        // Listen to kurir change to update ongkir dynamically
        document.querySelectorAll('input[name="kurir"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const ongkir = ongkirMapping[this.value] || 15000;

                // Update UI & Hidden Input
                document.getElementById('shippingCostDisplay').innerText = formatRupiah(ongkir);
                document.getElementById('shippingCostInput').value = ongkir;
                document.getElementById('summaryTotal').innerText = formatRupiah(baseSubtotal + ongkir);
            });
        });
    </script>

</body>
</html>