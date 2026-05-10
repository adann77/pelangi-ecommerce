<?php
// D:\Projek Akhir\pelangi-ecommerce\app\Http\Controllers\admin\RatingController.php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function index(Request $request)
    {
        $query = Rating::with(['user', 'produk']);

        // Filter pencarian nama produk
        if ($request->filled('search')) {
            $query->whereHas('produk', function ($q) use ($request) {
                $q->where('nama_produk', 'like', '%' . $request->search . '%');
            });
        }

        // Filter berdasarkan bintang
        if ($request->filled('bintang')) {
            $query->where('rating', $request->bintang);
        }

        $ratings = $query->latest()->paginate(10)->withQueryString();

        // Statistik
        $avgRating = Rating::avg('rating') ?? 0;
        $totalReviews = Rating::count();

        return view('admin.rating', compact('ratings', 'avgRating', 'totalReviews'));
    }

    public function toggleStatus($id)
    {
        $rating = Rating::findOrFail($id);
        
        // Ubah status
        $rating->status = $rating->status === 'aktif' ? 'disembunyikan' : 'aktif';
        $rating->save();

        return back()->with('success', 'Status rating berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $rating = Rating::findOrFail($id);
        $rating->delete();

        return back()->with('success', 'Rating berhasil dihapus!');
    }
}