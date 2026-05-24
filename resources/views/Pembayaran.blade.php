<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instruksi Pembayaran | Pelangi Accessories</title>
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

        @keyframes pulse-ring {
            0%   { transform: scale(0.95); opacity: 1; }
            50%  { transform: scale(1.05); opacity: 0.7; }
            100% { transform: scale(0.95); opacity: 1; }
        }
        .qr-pulse {
            animation: pulse-ring 2s ease-in-out infinite;
        }

        @keyframes countdown-pulse {
            0%, 100% { transform: scale(1); }
            50%      { transform: scale(1.05); }
        }
        .countdown-pulse {
            animation: countdown-pulse 1s ease-in-out infinite;
        }
    </style>
</head>

<body class="bg-gray-50 font-sans text-gray-800 antialiased selection:bg-violet-200 selection:text-violet-800 flex flex-col min-h-screen">

    <!-- ==================== NAVBAR ==================== -->
    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="text-xl md:text-2xl font-bold flex items-center gap-2">
                        <img src="{{ asset('storage/image/logo.png') }}" alt="Logo Pelangi" class="w-8 h-8 md:w-10 md:h-10 object-contain" onerror="this.outerHTML='<div class=\'w-8 h-8 md:w-10 md:h-10 bg-gray-200 rounded-full flex items-center justify-center text-[10px] text-gray-500\'>Logo</div>'">
                        <span class="text-gray-900">Pelangi</span> <span class="text-pink-500">Accessories</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- ==================== MAIN ==================== -->
    <main class="flex-1 w-full max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Breadcrumbs -->
        <nav class="flex text-sm font-medium text-gray-500 mb-8">
            <ol class="flex items-center space-x-2">
                <li><a href="{{ route('home') }}" class="hover:text-violet-600 transition-colors">Beranda</a></li>
                <li><svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></li>
                <li><span class="text-gray-900">Instruksi Pembayaran</span></li>
            </ol>
        </nav>

        <!-- Alert Sukses -->
        @if(session('success'))
            <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 mb-6 rounded-r-xl flex items-center gap-3">
                <svg class="w-6 h-6 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="text-sm font-medium text-emerald-700">{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            
            <!-- Header -->
            <div class="bg-gradient-to-r from-violet-600 to-pink-500 p-6 text-white text-center">
                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h2 class="text-xl font-bold mb-1">Pesanan Berhasil Dibuat!</h2>
                <p class="text-white/80 text-sm">Selesaikan pembayaran sebelum batas waktu</p>
            </div>

            <!-- Countdown Timer -->
            <div class="bg-amber-50 border-b border-amber-100 px-6 py-4 text-center">
                <p class="text-xs text-amber-600 font-medium mb-1">Batas waktu pembayaran</p>
                <div class="flex items-center justify-center gap-2" id="countdownTimer">
                    <div class="bg-white rounded-lg px-3 py-2 shadow-sm border border-amber-200">
                        <span class="text-2xl font-extrabold text-amber-700 countdown-pulse" id="timerHours">23</span>
                        <p class="text-[9px] text-amber-500 font-medium uppercase tracking-wider">Jam</p>
                    </div>
                    <span class="text-xl font-bold text-amber-400">:</span>
                    <div class="bg-white rounded-lg px-3 py-2 shadow-sm border border-amber-200">
                        <span class="text-2xl font-extrabold text-amber-700 countdown-pulse" id="timerMinutes">59</span>
                        <p class="text-[9px] text-amber-500 font-medium uppercase tracking-wider">Menit</p>
                    </div>
                    <span class="text-xl font-bold text-amber-400">:</span>
                    <div class="bg-white rounded-lg px-3 py-2 shadow-sm border border-amber-200">
                        <span class="text-2xl font-extrabold text-amber-700 countdown-pulse" id="timerSeconds">59</span>
                        <p class="text-[9px] text-amber-500 font-medium uppercase tracking-wider">Detik</p>
                    </div>
                </div>
            </div>

            <div class="p-6 md:p-8 space-y-6">
                
                <!-- Informasi Pesanan -->
                <div class="bg-gray-50 rounded-xl p-5 border border-gray-100">
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-sm text-gray-500">Order ID</span>
                        <span class="font-bold text-violet-600 text-sm tracking-wider">PLG-{{ str_pad($pesanan->id_pesanan, 4, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-sm text-gray-500">Metode Pembayaran</span>
                        <span class="text-sm font-semibold text-gray-800 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                            {{ $pesanan->pembayaran->metode_pembayaran ?? 'QRIS' }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-sm text-gray-500">Status</span>
                        <span class="text-xs font-bold bg-amber-100 text-amber-700 px-3 py-1 rounded-full uppercase tracking-wider">
                            {{ $pesanan->pembayaran->status_pembayaran ?? 'Pending' }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center pt-3 border-t border-gray-200 mt-3">
                        <span class="text-sm text-gray-500">Total Pembayaran</span>
                        <span class="text-lg font-extrabold text-gray-900">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- QR Code -->
                <div class="text-center py-8 border-2 border-dashed border-violet-200 rounded-2xl bg-gradient-to-b from-violet-50 to-white relative">
                    <!-- Badge QRIS -->
                    <div class="absolute -top-3 left-1/2 -translate-x-1/2">
                        <span class="bg-violet-600 text-white text-xs font-bold px-4 py-1.5 rounded-full shadow-md flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                            Scan QRIS
                        </span>
                    </div>

                    <p class="text-sm font-semibold text-gray-700 mt-4 mb-5">Scan QR Code di bawah ini untuk membayar</p>
                    
                    <div class="w-56 h-56 mx-auto bg-white p-3 rounded-xl border border-gray-200 shadow-lg qr-pulse">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=PelangiAccessories-QRIS-Pembayaran-{{ $pesanan->id_pesanan }}-{{ $pesanan->total_harga }}" alt="QRIS Code" class="w-full h-full object-contain">
                    </div>
                    
                    <p class="text-xs text-gray-400 mt-5">Gunakan aplikasi e-wallet atau mobile banking Anda</p>
                    
                    <!-- Supported Apps Icons -->
                    <div class="flex items-center justify-center gap-3 mt-3">
                        <span class="bg-gray-100 text-gray-500 text-[10px] font-bold px-2 py-1 rounded">GoPay</span>
                        <span class="bg-gray-100 text-gray-500 text-[10px] font-bold px-2 py-1 rounded">OVO</span>
                        <span class="bg-gray-100 text-gray-500 text-[10px] font-bold px-2 py-1 rounded">DANA</span>
                        <span class="bg-gray-100 text-gray-500 text-[10px] font-bold px-2 py-1 rounded">ShopeePay</span>
                        <span class="bg-gray-100 text-gray-500 text-[10px] font-bold px-2 py-1 rounded">BCA</span>
                    </div>
                </div>

                <!-- Petunjuk -->
                <div class="bg-amber-50 border border-amber-100 rounded-xl p-4">
                    <h4 class="font-semibold text-amber-800 text-sm mb-2 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Cara Pembayaran via QRIS
                    </h4>
                    <ol class="list-decimal list-inside text-xs text-amber-700 space-y-1.5">
                        <li>Buka aplikasi e-wallet atau mobile banking Anda.</li>
                        <li>Pilih menu <strong>"Scan QR"</strong> atau <strong>"Pembayaran QRIS"</strong>.</li>
                        <li>Arahkan kamera ke <strong>QR Code</strong> di atas.</li>
                        <li>Periksa detail pembayaran: <strong>PLG-{{ str_pad($pesanan->id_pesanan, 4, '0', STR_PAD_LEFT) }}</strong> sebesar <strong>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</strong>.</li>
                        <li>Konfirmasi dan masukkan PIN Anda.</li>
                        <li>Pembayaran akan diverifikasi otomatis oleh sistem.</li>
                    </ol>
                </div>

                <!-- Perhatian -->
                <div class="bg-red-50 border border-red-100 rounded-xl p-4">
                    <h4 class="font-semibold text-red-700 text-sm mb-2 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
                        Perhatian
                    </h4>
                    <ul class="list-disc list-inside text-xs text-red-600 space-y-1">
                        <li>Jangan membagikan QR Code ini kepada siapapun.</li>
                        <li>Pembayaran hanya melalui QR Code resmi di halaman ini.</li>
                        <li>Pesanan akan otomatis dibatalkan jika tidak dibayar dalam 24 jam.</li>
                    </ul>
                </div>

            </div>

            <!-- Footer Action -->
            <div class="bg-gray-50 px-6 md:px-8 py-5 border-t border-gray-100 flex flex-col sm:flex-row gap-3 justify-end">
                <a href="{{ route('home') }}" class="px-6 py-2.5 border border-gray-200 text-gray-700 rounded-xl font-semibold text-sm hover:bg-gray-100 transition-colors text-center">
                    Kembali Belanja
                </a>
                <a href="/dashboard" class="px-6 py-2.5 bg-gradient-to-r from-violet-600 to-pink-500 text-white rounded-xl font-semibold text-sm hover:shadow-md transition-colors text-center">
                    Cek Status Pesanan
                </a>
            </div>
        </div>

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
        // ★ Countdown Timer (24 jam dari halaman dibuka)
        let totalSeconds = 24 * 60 * 60; // 24 jam

        function updateCountdown() {
            if (totalSeconds <= 0) {
                document.getElementById('timerHours').textContent = '00';
                document.getElementById('timerMinutes').textContent = '00';
                document.getElementById('timerSeconds').textContent = '00';
                return;
            }

            const hours   = Math.floor(totalSeconds / 3600);
            const minutes = Math.floor((totalSeconds % 3600) / 60);
            const seconds = totalSeconds % 60;

            document.getElementById('timerHours').textContent   = String(hours).padStart(2, '0');
            document.getElementById('timerMinutes').textContent = String(minutes).padStart(2, '0');
            document.getElementById('timerSeconds').textContent = String(seconds).padStart(2, '0');

            totalSeconds--;
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);
    </script>

</body>
</html>