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

        .radio-card input[type="radio"]:checked + label {
            border-color: #8b5cf6;
            background-color: #f5f3ff;
            color: #7c3aed;
        }
        .radio-card input[type="radio"]:checked + label .radio-dot {
            background-color: #8b5cf6;
            box-shadow: 0 0 0 3px white, 0 0 0 5px #8b5cf6;
        }

        /* Toast notification */
        .toast-enter {
            animation: slideIn 0.3s ease-out forwards;
        }
        .toast-exit {
            animation: slideOut 0.3s ease-in forwards;
        }
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to   { transform: translateX(0);    opacity: 1; }
        }
        @keyframes slideOut {
            from { transform: translateX(0);    opacity: 1; }
            to   { transform: translateX(100%); opacity: 0; }
        }
    </style>
</head>

<body class="bg-gray-50 font-sans text-gray-800 antialiased selection:bg-violet-200 selection:text-violet-800 flex flex-col min-h-screen">

    <!-- ==================== TOAST CONTAINER ==================== -->
    <div id="toastContainer" class="fixed top-6 right-6 z-[9999] space-y-3"></div>

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
                        <a href="/dashboard" class="text-violet-600 hover:text-pink-400 font-medium transition-colors">{{ auth()->user()->nama }}</a>
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
                                <input type="text" name="nama_penerima" value="{{ auth()->user()->nama ?? '' }}" required class="w-full bg-gray-50 border border-gray-200 rounded-xl py-2.5 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-violet-300 focus:border-violet-300 focus:bg-white transition-all" placeholder="Nama lengkap">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">No. Telepon <span class="text-red-500">*</span></label>
                                <input type="tel" name="no_telepon" value="{{ auth()->user()->no_hp ?? '' }}" required class="w-full bg-gray-50 border border-gray-200 rounded-xl py-2.5 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-violet-300 focus:border-violet-300 focus:bg-white transition-all" placeholder="08xxxxxxxxxx">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap <span class="text-red-500">*</span></label>
                                <textarea name="alamat_lengkap" rows="3" required class="w-full bg-gray-50 border border-gray-200 rounded-xl py-2.5 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-violet-300 focus:border-violet-300 focus:bg-white transition-all resize-none" placeholder="Nama jalan, nomor rumah, RT/RW, Kelurahan, Kecamatan">{{ auth()->user()->alamat ?? '' }}</textarea>
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
                                <input type="radio" name="kurir" id="kurir_jne" value="JNE" class="sr-only" required checked>
                                <label for="kurir_jne" class="border-2 border-gray-200 rounded-xl p-4 flex items-center justify-between cursor-pointer transition-all hover:border-violet-300">
                                    <div>
                                        <p class="font-bold text-gray-800">JNE</p>
                                        <p class="text-xs text-gray-500 mt-1">Estimasi 2-3 hari</p>
                                    </div>
                                    <div class="radio-dot w-4 h-4 rounded-full bg-gray-200 border-2 border-white transition-all"></div>
                                </label>
                            </div>
                            <div class="radio-card">
                                <input type="radio" name="kurir" id="kurir_jnt" value="J&T" class="sr-only">
                                <label for="kurir_jnt" class="border-2 border-gray-200 rounded-xl p-4 flex items-center justify-between cursor-pointer transition-all hover:border-violet-300">
                                    <div>
                                        <p class="font-bold text-gray-800">J&T</p>
                                        <p class="text-xs text-gray-500 mt-1">Estimasi 2-4 hari</p>
                                    </div>
                                    <div class="radio-dot w-4 h-4 rounded-full bg-gray-200 border-2 border-white transition-all"></div>
                                </label>
                            </div>
                            <div class="radio-card">
                                <input type="radio" name="kurir" id="kurir_sicepat" value="SiCepat" class="sr-only">
                                <label for="kurir_sicepat" class="border-2 border-gray-200 rounded-xl p-4 flex items-center justify-between cursor-pointer transition-all hover:border-violet-300">
                                    <div>
                                        <p class="font-bold text-gray-800">SiCepat</p>
                                        <p class="text-xs text-gray-500 mt-1">Estimasi 1-2 hari</p>
                                    </div>
                                    <div class="radio-dot w-4 h-4 rounded-full bg-gray-200 border-2 border-white transition-all"></div>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Metode Pembayaran — HANYA QRIS AKTIF --}}
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                        <h2 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                            Metode Pembayaran
                        </h2>

                        <div class="space-y-6">
                            {{-- ★ QRIS — SATU-SATUNYA YANG AKTIF ★ --}}
                            <div>
                                <p class="text-sm font-semibold text-gray-500 mb-3">Scan QR Code (QRIS)</p>
                                <div class="grid grid-cols-1 gap-3">
                                    <div class="radio-card">
                                        <input type="radio" name="metode_pembayaran" id="pay_qris" value="QRIS" class="sr-only" required checked>
                                        <label for="pay_qris" class="border-2 border-violet-500 bg-violet-50 rounded-xl p-4 flex items-center gap-4 cursor-pointer transition-all">
                                            <div class="w-12 h-12 bg-violet-100 rounded-lg flex items-center justify-center">
                                                <svg class="w-7 h-7 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-sm font-bold text-violet-700">QRIS — Scan QR Code</p>
                                                <p class="text-xs text-violet-500 mt-0.5">Didukung semua e-wallet & mobile banking</p>
                                            </div>
                                            <div class="radio-dot w-4 h-4 rounded-full border-2 border-white transition-all" style="background-color:#8b5cf6;box-shadow:0 0 0 3px white,0 0 0 5px #8b5cf6;"></div>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            {{-- Virtual Account — DISABLED --}}
                            <div>
                                <p class="text-sm font-semibold text-gray-500 mb-3">Virtual Account / Transfer Bank</p>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                    <div onclick="showUnavailableToast('BCA Virtual Account')" class="border-2 border-gray-200 rounded-xl p-4 flex items-center gap-3 cursor-not-allowed opacity-50 hover:opacity-70 transition-all relative overflow-hidden">
                                        <span class="absolute top-2 right-2 bg-amber-100 text-amber-700 text-[9px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider">Segera Hadir</span>
                                        <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center text-blue-600 font-bold text-xs">BCA</div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-500">BCA</p>
                                            <p class="text-[10px] text-gray-400">Virtual Account</p>
                                        </div>
                                    </div>
                                    <div onclick="showUnavailableToast('BRI Virtual Account')" class="border-2 border-gray-200 rounded-xl p-4 flex items-center gap-3 cursor-not-allowed opacity-50 hover:opacity-70 transition-all relative overflow-hidden">
                                        <span class="absolute top-2 right-2 bg-amber-100 text-amber-700 text-[9px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider">Segera Hadir</span>
                                        <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center text-blue-900 font-bold text-xs">BRI</div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-500">BRI</p>
                                            <p class="text-[10px] text-gray-400">Virtual Account</p>
                                        </div>
                                    </div>
                                    <div onclick="showUnavailableToast('Mandiri Virtual Account')" class="border-2 border-gray-200 rounded-xl p-4 flex items-center gap-3 cursor-not-allowed opacity-50 hover:opacity-70 transition-all relative overflow-hidden">
                                        <span class="absolute top-2 right-2 bg-amber-100 text-amber-700 text-[9px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider">Segera Hadir</span>
                                        <div class="w-10 h-10 bg-yellow-50 rounded-lg flex items-center justify-center text-yellow-700 font-bold text-[10px]">MDR</div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-500">Mandiri</p>
                                            <p class="text-[10px] text-gray-400">Virtual Account</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- E-Wallet — DISABLED --}}
                            <div>
                                <p class="text-sm font-semibold text-gray-500 mb-3">E-Wallet (Dompet Digital)</p>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                    <div onclick="showUnavailableToast('GoPay')" class="border-2 border-gray-200 rounded-xl p-4 flex items-center gap-3 cursor-not-allowed opacity-50 hover:opacity-70 transition-all relative overflow-hidden">
                                        <span class="absolute top-2 right-2 bg-amber-100 text-amber-700 text-[9px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider">Segera Hadir</span>
                                        <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center text-green-600 font-bold text-xs">GP</div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-500">GoPay</p>
                                            <p class="text-[10px] text-gray-400">E-Wallet</p>
                                        </div>
                                    </div>
                                    <div onclick="showUnavailableToast('OVO')" class="border-2 border-gray-200 rounded-xl p-4 flex items-center gap-3 cursor-not-allowed opacity-50 hover:opacity-70 transition-all relative overflow-hidden">
                                        <span class="absolute top-2 right-2 bg-amber-100 text-amber-700 text-[9px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider">Segera Hadir</span>
                                        <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center text-purple-600 font-bold text-xs">OVO</div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-500">OVO</p>
                                            <p class="text-[10px] text-gray-400">E-Wallet</p>
                                        </div>
                                    </div>
                                    <div onclick="showUnavailableToast('DANA')" class="border-2 border-gray-200 rounded-xl p-4 flex items-center gap-3 cursor-not-allowed opacity-50 hover:opacity-70 transition-all relative overflow-hidden">
                                        <span class="absolute top-2 right-2 bg-amber-100 text-amber-700 text-[9px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider">Segera Hadir</span>
                                        <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center text-blue-500 font-bold text-xs">DANA</div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-500">DANA</p>
                                            <p class="text-[10px] text-gray-400">E-Wallet</p>
                                        </div>
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
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500">Metode Bayar</span>
                                <span class="font-semibold text-violet-600 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                                    QRIS
                                </span>
                            </div>
                        </div>

                        <hr class="my-5 border-gray-100">

                        <div class="flex justify-between items-center mb-6">
                            <span class="text-base font-bold text-gray-900">Total</span>
                            <span class="text-xl font-extrabold text-violet-600" id="summaryTotal">Rp {{ number_format(($keranjang->total_harga ?? 0) + 15000, 0, ',', '.') }}</span>
                        </div>

                        <button type="submit" id="btnCheckout" class="w-full py-3.5 bg-gradient-to-r from-violet-600 to-pink-500 text-white rounded-xl font-bold hover:shadow-lg hover:scale-[1.02] transition-all shadow-md shadow-violet-500/20 text-sm flex items-center justify-center gap-2">
                            <svg class="w-5 h-5 hidden animate-spin" id="spinner" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span id="btnText">Bayar dengan QRIS</span>
                        </button>

                        <a href="{{ route('keranjang.index') }}" class="block text-center mt-4 text-sm font-semibold text-violet-600 hover:text-violet-700 transition-colors">
                            ← Kembali ke Keranjang
                        </a>

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

        const baseSubtotal = {{ $keranjang->total_harga ?? 0 }};

        const ongkirMapping = {
            'JNE': 15000,
            'J&T': 18000,
            'SiCepat': 17000
        };

        // Listen to kurir change
        document.querySelectorAll('input[name="kurir"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const ongkir = ongkirMapping[this.value] || 15000;
                document.getElementById('shippingCostDisplay').innerText = formatRupiah(ongkir);
                document.getElementById('shippingCostInput').value = ongkir;
                document.getElementById('summaryTotal').innerText = formatRupiah(baseSubtotal + ongkir);
            });
        });

        // ★ Toast Notification for Unavailable Payment Methods
        function showUnavailableToast(methodName) {
            const container = document.getElementById('toastContainer');
            
            const toast = document.createElement('div');
            toast.className = 'toast-enter flex items-center gap-3 bg-white border border-amber-200 shadow-lg rounded-xl px-5 py-4 min-w-[300px] max-w-sm';
            toast.innerHTML = `
                <div class="flex-shrink-0 w-9 h-9 bg-amber-100 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-800">${methodName}</p>
                    <p class="text-xs text-amber-600 mt-0.5">Metode pembayaran ini belum tersedia. Silakan gunakan QRIS.</p>
                </div>
            `;
            
            container.appendChild(toast);
            
            // Auto remove after 3 seconds
            setTimeout(() => {
                toast.classList.remove('toast-enter');
                toast.classList.add('toast-exit');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        // Anti Double Click & Loading Spinner
        document.getElementById('checkoutForm').addEventListener('submit', function(e) {
            const btn = document.getElementById('btnCheckout');
            const spinner = document.getElementById('spinner');
            const text = document.getElementById('btnText');
            
            btn.disabled = true;
            btn.classList.add('opacity-80', 'cursor-not-allowed');
            
            spinner.classList.remove('hidden');
            text.innerText = 'Memproses Pesanan...';
        });
    </script>

</body>
</html>