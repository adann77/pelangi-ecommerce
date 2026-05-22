<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KatalogController extends Controller
{
    /**
     * Menampilkan halaman katalog produk (dengan filter & search).
     */
    public function index(Request $request): View
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        $maxPriceLimit = (int) (Produk::max('harga') ?? 500000);

        // ✅ FIX: Tambah with('varians') agar accessor gambar_url
        //    bisa pakai eager-load tanpa N+1 query
        $query = Produk::with('kategori', 'varians')
            ->withAvg('ratings', 'rating')
            ->withCount('ratings');

        // Filter: Kategori
        if ($request->filled('id_kategori')) {
            $query->where('id_kategori', $request->id_kategori);
        }

        // Filter: Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_produk', 'like', "%{$search}%")
                  ->orWhereHas('kategori', function ($q) use ($search) {
                      $q->where('nama_kategori', 'like', "%{$search}%");
                  });
            });
        }

        // Filter: Price Range
        if ($request->filled('min_price')) {
            $query->where('harga', '>=', (int) $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('harga', '<=', (int) $request->max_price);
        }

        // Sorting
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('harga', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('harga', 'desc');
                break;
            case 'popular':
                $query->orderByDesc('ratings_count');
                break;
            default:
                $query->latest();
                break;
        }

        $produks = $query->get();

        // Kategori terpilih (untuk judul & highlight)
        $selectedKategori = null;
        if ($request->filled('id_kategori')) {
            $selectedKategori = Kategori::find($request->id_kategori);
        }

        return view('katalog', compact(
            'kategoris', 'produks', 'maxPriceLimit', 'selectedKategori'
        ));
    }

    /**
     * Menampilkan halaman detail produk.
     */
    public function detail($id): View
    {
        // Ambil produk beserta relasi kategori dan rating (beserta user-nya)
        $produk = Produk::with(['kategori', 'ratings.user', 'gambars', 'varians'])->findOrFail($id);

        // ✅ FIX: Eager-load varians untuk produk terkait juga
        $relatedProduks = Produk::with('kategori', 'varians')
            ->where('id_kategori', $produk->id_kategori)
            ->where('id_produk', '!=', $produk->id_produk)
            ->inRandomOrder()
            ->take(4)
            ->get();

        // Hitung rata-rata rating
        $avgRating = $produk->ratings->avg('rating') ?? 0;

        // Hitung total review
        $totalReviews = $produk->ratings->count();

        // Hitung distribusi rating (untuk bar chart bintang 5-1)
        $ratingDistribution = [];
        for ($i = 5; $i >= 1; $i--) {
            $ratingDistribution[$i] = $produk->ratings->where('rating', $i)->count();
        }

        return view('detail', compact(
            'produk',
            'relatedProduks',
            'avgRating',
            'totalReviews',
            'ratingDistribution'
        ));
    }
}