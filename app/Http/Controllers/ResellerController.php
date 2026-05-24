<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ResellerController extends Controller
{
    /**
     * Tampilkan form pendaftaran reseller
     */
    public function create()
    {
        $user = auth()->user();

        // Jika sudah menjadi reseller, langsung redirect ke dashboard
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

        // Jika sudah menjadi reseller, jangan proses lagi
        if ($user->role === 'reseller') {
            return redirect()->route('reseller.dashboard');
        }

        $validated = $request->validate([
            'no_hp'   => 'required|string|max:15',
            'alamat'  => 'required|string',
            'bukti_pembayaran' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'no_hp.required'   => 'No. HP wajib diisi.',
            'alamat.required'  => 'Alamat lengkap wajib diisi.',
            'bukti_pembayaran.required' => 'Bukti pembayaran wajib diunggah.',
            'bukti_pembayaran.image'    => 'File harus berupa gambar.',
            'bukti_pembayaran.mimes'    => 'Format file harus JPG, JPEG, atau PNG.',
            'bukti_pembayaran.max'      => 'Ukuran file maksimal 2MB.',
        ]);

        // Upload bukti pembayaran
        $buktiPath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');

        // Update data user: ubah role menjadi reseller
        $user->update([
            'no_hp'            => $validated['no_hp'],
            'alamat'           => $validated['alamat'],
            'bukti_pembayaran' => $buktiPath,
            'role'             => 'reseller',
            'status_reseller'  => 'approved',
        ]);

        return redirect()->route('reseller.register.success');
    }

    /**
     * Tampilkan halaman sukses pendaftaran
     */
    public function success()
    {
        // Pastikan hanya reseller yang bisa akses halaman ini
        if (auth()->user()->role !== 'reseller') {
            return redirect()->route('home');
        }

        return view('pendaftaran-sukses');
    }

    /**
     * Dashboard reseller
     */
    public function dashboard()
    {
        return view('reseller.dashboard');
    }

/**
     * Setujui pendaftaran reseller -> Ubah role jadi reseller
     */
    public function approve($id_user)
    {
        $reseller = User::where('id_user', $id_user)->firstOrFail();
        
        $reseller->update([
            'status_reseller' => 'approved',
            'role' => 'reseller' // OTOMATIS UBAH ROLE JADI RESELLER
        ]);

        return back()->with('success', 'Pendaftaran reseller telah disetujui. Role user berubah menjadi Reseller.');
    }

    /**
     * Tolak pendaftaran reseller -> Role tetap customer
     */
    public function reject($id_user)
    {
        $reseller = User::where('id_user', $id_user)->firstOrFail();
        
        $reseller->update([
            'status_reseller' => 'rejected',
            'role' => 'customer' // PASTIKAN TETAP CUSTOMER
        ]);

        return back()->with('success', 'Pendaftaran reseller telah ditolak.');
    }
}

