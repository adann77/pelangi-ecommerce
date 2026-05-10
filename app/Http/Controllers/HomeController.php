<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\View\View;

class HomeController extends Controller // ← UBAH KE HomeController
{
    /**
     * Tampilkan halaman beranda dengan data dinamis dari database.
     */
    public function index(): View
    {
        // Ambil semua kategori
        $kategoris = Kategori::orderBy('nama_kategori')->get();

        // Ambil 8 produk terbaru beserta rata-rata rating & jumlah review
        $produks = Produk::with('kategori')
            ->withAvg('ratings', 'rating')
            ->withCount('ratings')
            ->latest()
            ->take(8)
            ->get();

        return view('home', compact('kategoris', 'produks'));
    }
}