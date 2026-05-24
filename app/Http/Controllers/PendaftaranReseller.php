<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PendaftaranReseller extends Controller
{
    /**
     * Tampilkan form pendaftaran reseller
     */
    public function create()
    {
        $user = auth()->user();

        // Jika sudah reseller, langsung ke dashboard
        if ($user->role === 'reseller') {
            return redirect()->route('reseller.dashboard');
        }

        return view('pendaftaran-reseller');
    }

    /**
     * Simpan data pendaftaran reseller
     */
     public function store(Request $request)
    {
        $user = auth()->user();

        // Jika sudah reseller, jangan proses lagi
        if ($user->role === 'reseller') {
            return redirect()->route('reseller.dashboard');
        }

        $validated = $request->validate([
            'no_hp'             => 'required|string|max:15',
            'alamat'            => 'required|string',
            'bukti_pembayaran'  => 'required|image|mimes:jpg,jpeg,png|max:5120',
        ], [
            'no_hp.required'            => 'No. HP wajib diisi.',
            'alamat.required'           => 'Alamat lengkap wajib diisi.',
            'bukti_pembayaran.required' => 'Bukti pembayaran wajib diunggah.',
            'bukti_pembayaran.image'    => 'File harus berupa gambar.',
            'bukti_pembayaran.mimes'    => 'Format file harus JPG, JPEG, atau PNG.',
            'bukti_pembayaran.max'      => 'Ukuran file maksimal 5MB.',
        ]);

        $buktiPath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');

        // ▼ DIUBAH: Role tetap 'customer', status_reseller menjadi 'pending' (Di Proses)
        $user->update([
            'no_hp'            => $validated['no_hp'],
            'alamat'           => $validated['alamat'],
            'bukti_pembayaran' => $buktiPath,
            'role'             => 'customer',   // Tetap customer
            'status_reseller'  => 'pending',    // Menunggu persetujuan admin
        ]);

        return redirect()->route('reseller.register.success');
    }

    /**
     * Tampilkan halaman sukses pendaftaran
     */
   // Method SUCCESS (Ganti yang lama)
    public function success()
    {
        $user = auth()->user();

        // Jika belum pernah mendaftar, lempar ke home
        if (!$user->status_reseller) {
            return redirect()->route('home');
        }

        // Jika sudah disetujui admin, langsung masuk dashboard reseller
        if ($user->role === 'reseller' && $user->status_reseller === 'approved') {
            return redirect()->route('reseller.dashboard');
        }

        // Jika status pending atau rejected, tampilkan halaman status
        return view('pendaftaran-sukses');
    }
}