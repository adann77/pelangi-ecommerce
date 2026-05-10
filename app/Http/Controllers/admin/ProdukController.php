<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    /**
     * Tampilkan daftar produk (dengan search & filter kategori).
     */
    public function index(Request $request): View
    {
        $query = Produk::with('kategori');

        // Pencarian nama produk atau kategori
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_produk', 'like', "%{$search}%")
                  ->orWhereHas('kategori', fn ($k) =>
                        $k->where('nama_kategori', 'like', "%{$search}%")
                  );
            });
        }

        // Filter by kategori
        if ($idKategori = $request->input('id_kategori')) {
            $query->where('id_kategori', $idKategori);
        }

        $produks   = $query->latest()->paginate(10)->withQueryString();
        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view('admin.produk', compact('produks', 'kategoris'));
    }

    /**
     * Simpan produk baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_kategori'    => 'required|exists:kategori,id_kategori',
            'nama_produk'    => 'required|string|max:100',
            'deskripsi'      => 'nullable|string',
            'harga'          => 'required|numeric|min:0',
            'harga_reseller' => 'nullable|numeric|min:0',
            'stok'           => 'required|integer|min:0',
            'gambar_produk'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('gambar_produk')) {
            $validated['gambar_produk'] = $request->file('gambar_produk')
                ->store('produk', 'public');
        }

        Produk::create($validated);

        return redirect()->route('admin.produk.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Perbarui produk yang sudah ada.
     */
    public function update(Request $request, Produk $produk): RedirectResponse
    {
        $validated = $request->validate([
            'id_kategori'    => 'required|exists:kategori,id_kategori',
            'nama_produk'    => 'required|string|max:100',
            'deskripsi'      => 'nullable|string',
            'harga'          => 'required|numeric|min:0',
            'harga_reseller' => 'nullable|numeric|min:0',
            'stok'           => 'required|integer|min:0',
            'gambar_produk'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('gambar_produk')) {
            // Hapus gambar lama jika ada
            if ($produk->gambar_produk) {
                Storage::disk('public')->delete($produk->gambar_produk);
            }
            $validated['gambar_produk'] = $request->file('gambar_produk')
                ->store('produk', 'public');
        }

        $produk->update($validated);

        return redirect()->route('admin.produk.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Hapus produk beserta gambarnya.
     */
    public function destroy(Produk $produk): RedirectResponse
    {
        if ($produk->gambar_produk) {
            Storage::disk('public')->delete($produk->gambar_produk);
        }

        $produk->delete();

        return redirect()->route('admin.produk.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}