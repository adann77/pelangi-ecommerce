<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = auth()->user();

        // Tentukan rute default berdasarkan role
        $defaultRoute = match ($user->role) {
            'admin'    => route('admin.dashboard'),
            'reseller' => route('reseller.dashboard'),
            default    => route('customer.dashboard'),
        };

        // ▼ MAGIC DI SINI ▼
        // redirect()->intended() akan mengecek apakah ada URL yang sebelumnya 
        // ingin dikunjungi user tapi diblokir oleh middleware auth.
        // Contoh: User klik "Daftar Reseller" -> diarahkan ke login -> 
        // setelah login berhasil, dia OTOMATIS kembali ke halaman pendaftaran reseller.
        // Jika tidak ada URL intended, maka akan pakai $defaultRoute di atas.
        return redirect()->intended($defaultRoute);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}