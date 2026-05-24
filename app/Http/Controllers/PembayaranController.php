<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function show($id_pesanan)
    {
        // Ambil data pesanan beserta detail produk dan data pembayarannya
        $pesanan = Pesanan::with('details.produk', 'pembayaran')->where('id_pesanan', $id_pesanan)->firstOrFail();

        // Keamanan: Pastikan user yang akses adalah pemilik pesanan
        if ($pesanan->id_user !== auth()->id()) {
            abort(403, 'Akses ditolak.');
        }

        return view('Pembayaran', compact('pesanan'));
    }
}