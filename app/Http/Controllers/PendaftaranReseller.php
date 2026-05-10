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

        // ▼ VALIDASI HANYA 3 FIELD INI ▼
        $validated = $request->validate([
            'no_hp'             => 'required|string|max:15',
            'alamat'            => 'required|string',
            'bukti_pembayaran'  => 'required|image|mimes:jpg,jpeg,png|max:5120', // ← DIUBAH: 5120 KB = 5MB
        ], [
            'no_hp.required'            => 'No. HP wajib diisi.',
            'alamat.required'           => 'Alamat lengkap wajib diisi.',
            'bukti_pembayaran.required' => 'Bukti pembayaran wajib diunggah.',
            'bukti_pembayaran.image'    => 'File harus berupa gambar.',
            'bukti_pembayaran.mimes'    => 'Format file harus JPG, JPEG, atau PNG.',
            'bukti_pembayaran.max'      => 'Ukuran file maksimal 5MB.', // ← DIUBAH: Pesan error
        ]);

        // Upload bukti pembayaran ke storage/app/public/bukti_pembayaran
        $buktiPath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');

        // Update data user yang sedang login
        $user->update([
            'no_hp'            => $validated['no_hp'],
            'alamat'           => $validated['alamat'],
            'bukti_pembayaran' => $buktiPath,
            'role'             => 'reseller',          // Ubah role menjadi reseller
            'status_reseller'  => 'approved',          // Langsung approved
        ]);

        return redirect()->route('reseller.register.success');
    }

    /**
     * Tampilkan halaman sukses pendaftaran
     */
    public function success()
    {
        // Hanya reseller yang boleh akses halaman ini
        if (auth()->user()->role !== 'reseller') {
            return redirect()->route('home');
        }

        return view('pendaftaran-sukses');
    }
}