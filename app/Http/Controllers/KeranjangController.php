<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\KeranjangDetail;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class KeranjangController extends Controller
{
    /**
     * Tampilkan halaman keranjang belanja.
     */
    public function index(): View
    {
        $keranjang = $this->getKeranjang();

        if ($keranjang) {
            $keranjang->load([
                'details.produk.kategori',
                'details.produk.varians',
                'details.varian',
            ]);

            // Sinkronkan subtotal setiap item (jaga-jika harga berubah)
            foreach ($keranjang->details as $detail) {
                if ($detail->produk) {
                    $detail->hitungSubtotal();
                }
            }
        }

        return view('keranjang', compact('keranjang'));
    }

    /**
     * Tambah item ke keranjang (AJAX).
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'id_produk' => 'required|exists:produk,id_produk',
            'kuantitas' => 'required|integer|min:1|max:99',
            'id_varian' => 'nullable|exists:produk_varian,id',
        ]);

        $produk   = Produk::findOrFail($request->id_produk);
        $kuantitas = (int) $request->kuantitas;
        $idVarian  = $request->id_varian ?: null;

        // ── Cek stok ──
        $stokTersedia = $this->cekStok($produk, $idVarian);
        if ($stokTersedia <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Produk sedang habis.',
            ], 422);
        }

        $keranjang = $this->getOrCreateKeranjang();

        // ── Cek apakah produk + varian sudah ada ──
        $existingDetail = $keranjang->details()
            ->where('id_produk', $request->id_produk)
            ->where('id_varian', $idVarian)
            ->first();

        if ($existingDetail) {
            $newQty = $existingDetail->kuantitas + $kuantitas;

            if ($newQty > $stokTersedia) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok tidak mencukupi. Di keranjang: ' . $existingDetail->kuantitas . ', Tersedia: ' . $stokTersedia,
                ], 422);
            }

            $existingDetail->kuantitas = $newQty;
            $existingDetail->subtotal  = $produk->harga_aktif * $newQty;
            $existingDetail->save();
        } else {
            if ($kuantitas > $stokTersedia) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok tidak mencukupi. Tersedia: ' . $stokTersedia,
                ], 422);
            }

            KeranjangDetail::create([
                'id_keranjang' => $keranjang->id_keranjang,
                'id_produk'    => $request->id_produk,
                'id_varian'    => $idVarian,
                'kuantitas'    => $kuantitas,
                'subtotal'     => $produk->harga_aktif * $kuantitas,
            ]);
        }

        $totalItems = $keranjang->fresh()->details->sum('kuantitas');

        return response()->json([
            'success'     => true,
            'message'     => 'Produk berhasil ditambahkan ke keranjang!',
            'total_items' => $totalItems,
        ]);
    }

    /**
     * Update kuantitas item keranjang (AJAX).
     */
    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'kuantitas' => 'required|integer|min:1|max:99',
        ]);

        $detail = KeranjangDetail::with('produk', 'keranjang')->findOrFail($id);

        // Otorisasi: pastikan item milik user login
        if ($detail->keranjang->id_user !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 403);
        }

        // Cek stok
        $stokTersedia = $this->cekStok($detail->produk, $detail->id_varian);
        if ($request->kuantitas > $stokTersedia) {
            return response()->json([
                'success' => false,
                'message' => 'Stok tidak mencukupi. Tersedia: ' . $stokTersedia,
            ], 422);
        }

        $detail->kuantitas = $request->kuantitas;
        $detail->subtotal  = $detail->produk->harga_aktif * $request->kuantitas;
        $detail->save();

        $keranjang = $detail->keranjang->fresh();
        $keranjang->load('details.produk');

        return response()->json([
            'success'      => true,
            'message'      => 'Kuantitas diperbarui.',
            'subtotal_item' => 'Rp ' . number_format($detail->subtotal, 0, ',', '.'),
            'total_harga'  => 'Rp ' . number_format($keranjang->details->sum('subtotal'), 0, ',', '.'),
            'total_items'  => $keranjang->details->sum('kuantitas'),
            'item_count'   => $keranjang->details->count(),
        ]);
    }

    /**
     * Hapus satu item dari keranjang (AJAX).
     */
    public function destroy($id): JsonResponse
    {
        $detail = KeranjangDetail::with('keranjang')->findOrFail($id);

        if ($detail->keranjang->id_user !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 403);
        }

        $detail->delete();

        $keranjang  = $detail->keranjang->fresh();
        $totalItems = $keranjang ? $keranjang->details->sum('kuantitas') : 0;
        $totalHarga = $keranjang ? $keranjang->details->sum('subtotal') : 0;
        $itemCount  = $keranjang ? $keranjang->details->count() : 0;

        return response()->json([
            'success'      => true,
            'message'      => 'Produk dihapus dari keranjang.',
            'total_items'  => $totalItems,
            'total_harga'  => 'Rp ' . number_format($totalHarga, 0, ',', '.'),
            'item_count'   => $itemCount,
        ]);
    }

    /**
     * Kosongkan seluruh keranjang (AJAX).
     */
    public function clear(): JsonResponse
    {
        $keranjang = $this->getKeranjang();

        if ($keranjang) {
            $keranjang->details()->delete();
        }

        return response()->json([
            'success'     => true,
            'message'     => 'Keranjang dikosongkan.',
            'total_items' => 0,
        ]);
    }

    /* ═══════════════════════════════════════════
       Helper Methods
       ═══════════════════════════════════════════ */

    private function getKeranjang(): ?Keranjang
    {
        return Keranjang::where('id_user', auth()->id())->first();
    }

    private function getOrCreateKeranjang(): Keranjang
    {
        return Keranjang::firstOrCreate(['id_user' => auth()->id()]);
    }

    private function cekStok(Produk $produk, $idVarian = null): int
    {
        if ($idVarian) {
            $varian = $produk->varians()->find($idVarian);
            return $varian ? (int) $varian->stok_varian : 0;
        }

        // Jika produk punya varian, total stok = sum semua varian
        if ($produk->varians()->count() > 0) {
            return (int) $produk->varians->sum('stok_varian');
        }

        return (int) $produk->stok;
    }
}