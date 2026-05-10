<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengiriman;
use Illuminate\Http\Request;

class PengirimanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search', '');
        $status = $request->query('status', '');

        // Base query dari Pengiriman dengan eager loading pesanan.user
        $query = Pengiriman::with('pesanan.user');

        // Apply search filter
        $query->search($search);

        // Apply status filter
        $query->filterStatus($status);

        // ── Count metrics (unfiltered, always reflects totals) ──
        $perluDikirimCount    = Pengiriman::perluDikirim()->count();
        $dalamPerjalananCount = Pengiriman::dalamPerjalanan()->count();
        $selesaiCount         = Pengiriman::selesai()->count();
        $totalCount           = $perluDikirimCount + $dalamPerjalananCount + $selesaiCount;

        // Paginated results (filtered)
        $pengiriman = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.pengiriman', compact(
            'perluDikirimCount',
            'dalamPerjalananCount',
            'selesaiCount',
            'totalCount',
            'search',
            'status',
            'pengiriman',
        ));
    }

    public function show($id)
    {
        $pengiriman = Pengiriman::with([
            'pesanan.user',
            'pesanan.detailPesanan.produk',
            'pesanan.pembayaran',
        ])->findOrFail($id);

        return view('admin.pengiriman-show', compact('pengiriman'));
    }

    public function update(Request $request, $id)
    {
        $pengiriman = Pengiriman::findOrFail($id);

        $validated = $request->validate([
            'kurir'   => 'required|string|max:50',
            'layanan' => 'nullable|string|max:50',
            'ongkir'  => 'required|numeric|min:0',
            'no_resi' => 'nullable|string|max:50',
            'status'  => 'required|in:perlu_dikirim,dalam_perjalanan,selesai',
        ]);

        $pengiriman->update($validated);

        return redirect()
            ->route('admin.pengiriman.index')
            ->with('success', 'Data pengiriman berhasil diperbarui.');
    }
}