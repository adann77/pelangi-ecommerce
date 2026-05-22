<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk | Pelangi Accessories</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .input-focus { @apply focus:ring-2 focus:ring-violet-300 focus:border-violet-300 focus:bg-white transition-all; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased selection:bg-violet-200 selection:text-violet-800 min-h-screen flex flex-col">

    <!-- NAVBAR SIMPLIFIED -->
    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('home') }}" class="text-xl font-bold flex items-center gap-2">
                    <img src="{{ asset('storage/image/logo.png') }}" alt="Logo" class="w-8 h-8 object-contain" 
                         onerror="this.outerHTML='<div class=\'w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center text-[10px] text-gray-500\'>Logo</div>'">
                    <span class="text-gray-900">Pelangi</span> <span class="text-pink-500">Accessories</span>
                </a>
                <!-- <a href="{{ route('home') }}" class="text-gray-500 hover:text-violet-600 transition-colors text-sm font-medium">
                    &larr; Kembali ke Beranda
                </a> -->
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <main class="flex-grow flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md">
            
            <!-- Session Status -->
            @if(session('status'))
                <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Card Form -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-gray-800">Selamat Datang 👋</h2>
                    <p class="text-gray-500 text-sm mt-2">Masuk untuk melanjutkan belanja aksesoris favoritmu</p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Email') }}</label>
                        <input id="email" 
                               type="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required 
                               autofocus 
                               autocomplete="username"
                               class="block w-full bg-gray-100 border border-transparent rounded-lg py-3 px-4 text-sm text-gray-800 placeholder-gray-400 focus:outline-none input-focus @error('email') border-red-300 @enderror"
                               placeholder="contoh@email.com">
                        @error('email')
                            <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Kata Sandi') }}</label>
                        <input id="password" 
                               type="password" 
                               name="password" 
                               required 
                               autocomplete="current-password"
                               class="block w-full bg-gray-100 border border-transparent rounded-lg py-3 px-4 text-sm text-gray-800 placeholder-gray-400 focus:outline-none input-focus @error('password') border-red-300 @enderror"
                               placeholder="••••••••">
                        @error('password')
                            <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer">
                            <input id="remember_me" 
                                   type="checkbox" 
                                   class="rounded border-gray-300 text-violet-600 shadow-sm focus:ring-violet-500 cursor-pointer" 
                                   name="remember">
                            <span class="ms-2 text-sm text-gray-600">{{ __('Ingat saya') }}</span>
                        </label>

                        @if(Route::has('password.request'))
                            <a href="{{ route('password.request') }}" 
                               class="text-sm text-violet-600 hover:text-pink-400 font-medium transition-colors">
                                {{ __('Lupa kata sandi?') }}
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-violet-600 to-pink-400 text-white font-semibold py-3.5 rounded-full hover:shadow-lg hover:scale-[1.02] transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-violet-300 focus:ring-offset-2">
                        {{ __('Masuk') }}
                    </button>
                </form>

                <!-- Register Link -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-500">
                        {{ __('Belum punya akun?') }}
                        @if(Route::has('register'))
                            <a href="{{ route('register') }}" 
                               class="text-violet-600 hover:text-pink-400 font-semibold transition-colors">
                                {{ __('Daftar sekarang') }}
                            </a>
                        @endif
                    </p>
                </div>
            </div>

            <!-- Trust Badges -->
            <div class="mt-8 flex justify-center gap-6 text-gray-400">
                <div class="flex items-center gap-2 text-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    <span>Transaksi Aman</span>
                </div>
                <div class="flex items-center gap-2 text-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    <span>Data Terenkripsi</span>
                </div>
            </div>

        </div>
    </main>

    <!-- SIMPLE FOOTER -->
    <footer class="bg-white border-t border-gray-100 py-6">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-sm text-gray-400">&copy; {{ date('Y') }} Pelangi Accessories. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>