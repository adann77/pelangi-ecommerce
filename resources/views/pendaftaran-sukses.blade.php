<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Berhasil | Pelangi Accessories</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-pink-50 text-gray-800 antialiased">

    <div class="min-h-screen flex flex-col items-center justify-center px-4 py-12 relative overflow-hidden">
        
        <!-- Decorative Elements -->
        <div class="absolute top-10 left-10 w-40 h-40 bg-violet-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse"></div>
        <div class="absolute bottom-10 right-10 w-40 h-40 bg-pink-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse"></div>

        <div class="relative z-10 bg-white/80 backdrop-blur-md p-10 md:p-16 rounded-3xl shadow-2xl max-w-lg w-full text-center border border-white">
            
            <!-- Icon Sukses -->
            <div class="w-24 h-24 bg-gradient-to-br from-violet-500 to-pink-400 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                <svg class="w-14 h-14 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>

            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">Pendaftaran Berhasil!</h1>
            <p class="text-gray-600 mb-8 text-sm md:text-base">Selamat! Anda telah terdaftar sebagai Reseller Pelangi Accessories dan berhak mendapatkan berbagai keuntungan eksklusif.</p>

            <!-- Kartu Keuntungan -->
            <div class="bg-gradient-to-r from-violet-50 to-pink-50 border border-violet-100 p-6 rounded-2xl mb-8 text-left">
                <h4 class="font-bold text-gray-800 mb-3">Keuntungan Reseller</h4>
                <div class="flex items-center gap-4 bg-white p-4 rounded-xl shadow-sm">
                    <div class="w-12 h-12 bg-violet-600 rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="text-white font-bold text-lg">%</span>
                    </div>
                    <div>
                        <h5 class="font-bold text-violet-700">Diskon Eksklusif 10%</h5>
                        <p class="text-xs text-gray-500">Diskon tahunan telah aktif & berlaku untuk semua produk setiap pembelian.</p>
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="space-y-3">
                <a href="{{ route('reseller.dashboard') }}" class="block w-full bg-gradient-to-r from-violet-600 to-pink-500 text-white py-3.5 rounded-xl font-semibold hover:shadow-lg hover:scale-[1.02] transition-all duration-300">
                    Masuk Dashboard Reseller
                 </a>
                <a href="{{ route('home') }}" class="block w-full bg-gray-100 text-gray-600 py-3.5 rounded-xl font-semibold hover:bg-gray-200 transition-colors">
                    Kembali ke Beranda
                </a>
            </div>
        </div>

        <p class="text-xs text-gray-400 mt-8 relative z-10">&copy; {{ date('Y') }} Pelangi Accessories. Hak Cipta Dilindungi.</p>
    </div>

</body>
</html>