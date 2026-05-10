<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Pesanan::with('user')->orderBy('tanggal_pesanan', 'desc');

        // Fitur Pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id_pesanan', 'like', '%'.$search.'%')
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('nama', 'like', '%'.$search.'%');
                  });
            });
        }

        // Fitur Filter Status
        if ($request->has('status') && $request->status != '') {
            $query->where('status_pesanan', $request->status);
        }

        $pesanan = $query->paginate(10)->appends($request->query());

        return view('admin.pesanan', compact('pesanan'));
    }

    /**
     * Mengambil data detail pesanan untuk modal (AJAX)
     */
    public function show($id)
    {
        $pesanan = Pesanan::with('user')->findOrFail($id);
        return response()->json($pesanan);
    }

    /**
     * Update status pesanan dan nomor resi
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status_pesanan' => 'required|in:pending,diproses,dikirim,selesai,dibatalkan',
            'nomor_resi'     => 'nullable|string|max:50',
        ]);

        $pesanan = Pesanan::findOrFail($id);
        $pesanan->update([
            'status_pesanan' => $request->status_pesanan,
            'nomor_resi'     => $request->nomor_resi,
        ]);

        return response()->json(['success' => true, 'message' => 'Pesanan berhasil diperbarui!']);
    }
}