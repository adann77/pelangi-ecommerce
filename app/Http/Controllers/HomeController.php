<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Tampilkan halaman beranda dengan data dinamis dari database.
     */
    public function index(): View
    {
        // Ambil semua kategori
        $kategoris = Kategori::orderBy('nama_kategori')->get();

        // ✅ FIX: Tambah with('varians') agar accessor gambar_url
        //    bisa pakai eager-load tanpa N+1 query
        $produks = Produk::with('kategori', 'varians')
            ->withAvg('ratings', 'rating')
            ->withCount('ratings')
            ->latest()
            ->take(8)
            ->get();

        return view('home', compact('kategoris', 'produks'));
    }
}