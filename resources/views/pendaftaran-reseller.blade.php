<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Reseller | Pelangi Accessories</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased">

    <!-- Navbar Sederhana -->
    <nav class="bg-white border-b border-gray-100 shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-20">
            <a href="{{ route('home') }}" class="text-xl font-bold flex items-center gap-2">
                <span class="text-gray-900">Pelangi</span> <span class="text-pink-500">Accessories</span>
            </a>
        </div>
    </nav>

    <!-- Header Banner -->
    <div class="relative bg-gradient-to-r from-violet-600 to-pink-500 text-white py-16 overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <img src="https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80" class="w-full h-full object-cover">
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Daftar Menjadi Reseller<br>Pelangi Accessories</h1>
            <p class="text-lg text-white/90 max-w-2xl mx-auto">Bergabunglah dan dapatkan penghasilan tambahan dengan menjual aksesoris berkualitas premium.</p>
        </div>
    </div>

    <!-- Konten Form & Keuntungan -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            
            <!-- Kolom Kiri: Keuntungan & Biaya -->
            <div class="space-y-8">
                <!-- Keuntungan -->
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Keuntungan Eksklusif</h3>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <span class="text-violet-600 mt-1">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            </span>
                            <span>Diskon <strong>10%</strong> untuk semua produk</span>
                        </li>
                        
                        <li class="flex items-start gap-3">
                            <span class="text-violet-600 mt-1">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            </span>
                            <span>Materi promosi <strong>siap pakai</strong> (foto & video)</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-violet-600 mt-1">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            </span>
                            <span>Prioritas <strong>packing & pengiriman</strong></span>
                        </li>
                    </ul>
                </div>

                <!-- Biaya Pendaftaran -->
                <div class="bg-violet-600 text-white p-8 rounded-2xl shadow-lg relative overflow-hidden">
                    <div class="absolute -top-10 -right-10 w-32 h-32 bg-white opacity-10 rounded-full blur-xl"></div>
                    <h4 class="text-lg font-semibold mb-2 relative z-10">Biaya Pendaftaran</h4>
                    <div class="text-4xl font-extrabold mb-4 relative z-10">Rp 75.000</div>
                    <p class="text-sm text-violet-100 mb-6 relative z-10">Bayar sekali, nikmati keuntungan selamanya. Transfer ke rekening resmi di bawah ini:</p>
                    <div class="bg-white/20 backdrop-blur-sm p-4 rounded-xl relative z-10">
                        <p class="text-sm font-medium">Bank BCA - 1234567890</p>
                        <p class="text-xs text-violet-200 mt-1">a.n. Pelangi Accessories</p>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Form Pendaftaran -->
            <div class="bg-white p-8 md:p-10 rounded-2xl shadow-sm border border-gray-100 h-fit">
                <h3 class="text-2xl font-bold text-gray-800 mb-6">Formulir Pendaftaran</h3>
                
                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded">
                        <p class="text-sm text-red-700">Harap perbaiki kesalahan berikut:</p>
                        <ul class="list-disc list-inside text-sm text-red-600 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('reseller.register.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    
                    <!-- <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="nama" value="{{ old('nama') }}" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-violet-300 focus:border-violet-500 transition-colors" placeholder="Masukkan nama lengkap">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-violet-300 focus:border-violet-500 transition-colors" placeholder="contoh@email.com">
                    </div> -->

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">No. HP (WhatsApp)</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp') }}" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-violet-300 focus:border-violet-500 transition-colors" placeholder="08123456789">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                        <textarea name="alamat" rows="3" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-violet-300 focus:border-violet-500 transition-colors" placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>
                    </div>

                    <!-- <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input type="password" name="password" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-violet-300 focus:border-violet-500 transition-colors" placeholder="Minimal 8 karakter">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-violet-300 focus:border-violet-500 transition-colors" placeholder="Ulangi password">
                    </div> -->

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Bukti Pembayaran</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-violet-400 transition-colors">
                            <input type="file" name="bukti_pembayaran" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100">
                            <p class="text-xs text-gray-400 mt-2">Format: JPG, PNG (Maks. 5MB)</p>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-violet-600 to-pink-500 text-white py-3.5 rounded-xl font-bold text-lg hover:shadow-lg hover:scale-[1.02] transition-all duration-300 mt-4">
                        Daftar Sekarang
                    </button>
                </form>
            </div>

        </div>
    </section>

</body>
</html>