<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pendaftaran | Pelangi Accessories</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased">

    <nav class="bg-white border-b border-gray-100 shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-20">
            <a href="{{ route('home') }}" class="text-xl font-bold flex items-center gap-2">
                <span class="text-gray-900">Pelangi</span> <span class="text-pink-500">Accessories</span>
            </a>
        </div>
    </nav>

    <div class="flex items-center justify-center min-h-[80vh] px-4">
        <div class="bg-white p-8 md:p-12 rounded-2xl shadow-sm border border-gray-100 max-w-lg w-full text-center">
            
            @if(auth()->user()->status_reseller === 'pending')
                <!-- STATUS: DI PROSES -->
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-amber-100 mb-6">
                    <svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Pendaftaran Diterima!</h2>
                <p class="text-gray-500 mb-6">Terima kasih telah mendaftar. Data Anda sedang kami verifikasi. Mohon tunggu konfirmasi dari Admin.</p>
                <div class="bg-amber-50 border border-amber-200 text-amber-700 px-4 py-3 rounded-lg text-sm font-semibold">
                    Status: Di Proses
                </div>
            @elseif(auth()->user()->status_reseller === 'rejected')
                <!-- STATUS: DITOLAK -->
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-6">
                    <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Pendaftaran Ditolak</h2>
                <p class="text-gray-500 mb-6">Maaf, pendaftaran reseller Anda ditolak. Pastikan data dan bukti pembayaran yang dikirim valid.</p>
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm font-semibold mb-6">
                    Status: Ditolak
                </div>
                <a href="{{ route('reseller.register.create') }}" class="inline-block bg-violet-600 text-white px-6 py-2 rounded-lg hover:bg-violet-700 transition">Coba Daftar Ulang</a>
            @endif

        </div>
    </div>

</body>
</html>