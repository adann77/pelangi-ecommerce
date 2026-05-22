<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\ProdukGambar;
use App\Models\ProdukVarian;
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
        $query = Produk::with('kategori', 'varians', 'gambars');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_produk', 'like', "%{$search}%")
                  ->orWhereHas('kategori', fn ($k) =>
                        $k->where('nama_kategori', 'like', "%{$search}%")
                  );
            });
        }

        if ($idKategori = $request->input('id_kategori')) {
            $query->where('id_kategori', $idKategori);
        }

        $produks   = $query->latest()->paginate(10)->withQueryString();
        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view('admin.produk', compact('produks', 'kategoris'));
    }

    /**
     * Simpan produk baru ke database beserta varian dan gambar tambahan.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_kategori'              => 'required|exists:kategori,id_kategori',
            'nama_produk'              => 'required|string|max:100',
            'deskripsi'                => 'nullable|string',
            'harga'                    => 'required|numeric|min:0',
            'harga_reseller'           => 'nullable|numeric|min:0',
            'stok'                     => 'required|integer|min:0',
            'gambar_produk'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'gambar_utama_index'       => 'nullable|integer',
            'varians'                  => 'nullable|array',
            'varians.*.nama_varian'    => 'required_with:varians|string|max:50',
            'varians.*.stok_varian'    => 'required_with:varians|integer|min:0',
            'varians.*.gambar_varian'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'gambars'                  => 'nullable|array',
            'gambars.*'                => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // ✅ FIX: Jika harga_reseller kosong, otomatis 90% dari harga
        if (empty($validated['harga_reseller']) && !empty($validated['harga'])) {
            $validated['harga_reseller'] = round($validated['harga'] * 0.9);
        }

        // 1. Upload Gambar Utama (jika upload langsung)
        if ($request->hasFile('gambar_produk')) {
            $validated['gambar_produk'] = $request->file('gambar_produk')->store('produk', 'public');
        } else {
            unset($validated['gambar_produk']);
        }

        // 2. Simpan Data Produk Utama
        $produk = Produk::create($validated);

        // 3. Simpan Varian
        $variantImagePaths = [];
        if ($request->has('varians') && is_array($request->varians)) {
            foreach ($request->varians as $index => $varianData) {
                $gambarPath = null;

                if (isset($varianData['gambar_varian']) && $request->hasFile("varians.{$index}.gambar_varian")) {
                    $gambarPath = $request->file("varians.{$index}.gambar_varian")->store('produk/varian', 'public');
                }

                $produk->varians()->create([
                    'nama_varian'   => $varianData['nama_varian'],
                    'stok_varian'   => $varianData['stok_varian'],
                    'gambar_varian' => $gambarPath,
                ]);

                $variantImagePaths[$index] = $gambarPath;
            }
        }

        // Set Gambar Utama dari Varian berdasarkan gambar_utama_index
        if (!$produk->gambar_produk && $request->filled('gambar_utama_index')) {
            $selectedIdx = $request->gambar_utama_index;
            if (isset($variantImagePaths[$selectedIdx]) && $variantImagePaths[$selectedIdx]) {
                $produk->gambar_produk = $variantImagePaths[$selectedIdx];
                $produk->save();
            }
        }

        // 4. Simpan Gambar Tambahan
        if ($request->hasFile('gambars')) {
            foreach ($request->file('gambars') as $index => $file) {
                $path = $file->store('produk/gambar', 'public');

                $produk->gambars()->create([
                    'path_gambar' => $path,
                    'urutan'      => $index + 1,
                ]);
            }
        }

        return redirect()->route('admin.produk.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Perbarui produk yang sudah ada (beserta varian & gambarnya).
     */
    public function update(Request $request, Produk $produk): RedirectResponse
    {
        $validated = $request->validate([
            'id_kategori'                  => 'required|exists:kategori,id_kategori',
            'nama_produk'                  => 'required|string|max:100',
            'deskripsi'                    => 'nullable|string',
            'harga'                        => 'required|numeric|min:0',
            'harga_reseller'               => 'nullable|numeric|min:0',
            'stok'                         => 'required|integer|min:0',
            'gambar_produk'                => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'gambar_utama_path'            => 'nullable|string',
            'new_varians'                  => 'nullable|array',
            'new_varians.*.nama_varian'    => 'required_with:new_varians|string|max:50',
            'new_varians.*.stok_varian'    => 'required_with:new_varians|integer|min:0',
            'new_varians.*.gambar_varian'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'new_gambars'                  => 'nullable|array',
            'new_gambars.*'                => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // ✅ FIX: Jika harga_reseller kosong, otomatis 90% dari harga
        if (empty($validated['harga_reseller']) && !empty($validated['harga'])) {
            $validated['harga_reseller'] = round($validated['harga'] * 0.9);
        }

        // 1. Update Gambar Utama
        if ($request->hasFile('gambar_produk')) {
            if ($produk->gambar_produk) {
                Storage::disk('public')->delete($produk->gambar_produk);
            }
            $validated['gambar_produk'] = $request->file('gambar_produk')->store('produk', 'public');

        } elseif ($request->filled('gambar_utama_path')) {
            $validated['gambar_produk'] = $request->input('gambar_utama_path');
        } else {
            unset($validated['gambar_produk']);
        }

        // 2. Update Data Produk Utama
        $produk->update($validated);

        // 3. Hapus Varian yang dicentang hapus
        if ($request->has('delete_varians')) {
            foreach ($request->delete_varians as $varianId) {
                $varian = ProdukVarian::find($varianId);
                if ($varian) {
                    if ($varian->gambar_varian && $produk->gambar_produk !== $varian->gambar_varian) {
                        Storage::disk('public')->delete($varian->gambar_varian);
                    }
                    $varian->delete();
                }
            }
        }

        // 4. Tambah Varian Baru saat Edit
        if ($request->has('new_varians') && is_array($request->new_varians)) {
            foreach ($request->new_varians as $index => $varianData) {
                $gambarPath = null;

                if (isset($varianData['gambar_varian']) && $request->hasFile("new_varians.{$index}.gambar_varian")) {
                    $gambarPath = $request->file("new_varians.{$index}.gambar_varian")->store('produk/varian', 'public');
                }

                $produk->varians()->create([
                    'nama_varian'   => $varianData['nama_varian'],
                    'stok_varian'   => $varianData['stok_varian'],
                    'gambar_varian' => $gambarPath,
                ]);
            }
        }

        // 5. Hapus Gambar Tambahan yang dicentang hapus
        if ($request->has('delete_gambars')) {
            foreach ($request->delete_gambars as $gambarId) {
                $gambar = ProdukGambar::find($gambarId);
                if ($gambar) {
                    Storage::disk('public')->delete($gambar->path_gambar);
                    $gambar->delete();
                }
            }
        }

        // 6. Tambah Gambar Tambahan Baru saat Edit
        if ($request->hasFile('new_gambars')) {
            $lastUrutan = $produk->gambars()->max('urutan') ?? 0;
            foreach ($request->file('new_gambars') as $index => $file) {
                $path = $file->store('produk/gambar', 'public');

                $produk->gambars()->create([
                    'path_gambar' => $path,
                    'urutan'      => $lastUrutan + $index + 1,
                ]);
            }
        }

        return redirect()->route('admin.produk.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Hapus produk beserta gambarnya, variannya, dan gambar tambahannya.
     */
    public function destroy(Produk $produk): RedirectResponse
    {
        if ($produk->gambar_produk) {
            Storage::disk('public')->delete($produk->gambar_produk);
        }

        foreach ($produk->varians as $varian) {
            if ($varian->gambar_varian) {
                Storage::disk('public')->delete($varian->gambar_varian);
            }
            $varian->delete();
        }

        foreach ($produk->gambars as $gambar) {
            Storage::disk('public')->delete($gambar->path_gambar);
            $gambar->delete();
        }

        $produk->delete();

        return redirect()->route('admin.produk.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}