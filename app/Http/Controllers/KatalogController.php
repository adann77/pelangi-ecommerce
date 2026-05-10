<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KatalogController extends Controller
{
    public function index(Request $request): View
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        $maxPriceLimit = (int) (Produk::max('harga') ?? 500000);

        $query = Produk::with('kategori')
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
}