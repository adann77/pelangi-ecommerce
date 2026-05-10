<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    /**
     * Tampilkan halaman kategori dengan data dinamis.
     */
    public function index(Request $request)
    {
        $query = Kategori::withCount('produks');

        // Filter pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama_kategori', 'like', "%{$search}%");
        }

        $kategoris = $query->orderBy('nama_kategori')->paginate(10)->appends($request->query());

        return view('admin.kategori', compact('kategoris'));
    }

    /**
     * Simpan kategori baru.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kategori'   => 'required|string|max:100|unique:kategori,nama_kategori',
            'gambar_kategori' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ], [
            'nama_kategori.required'   => 'Nama kategori wajib diisi.',
            'nama_kategori.max'        => 'Nama kategori maksimal 100 karakter.',
            'nama_kategori.unique'     => 'Nama kategori sudah ada.',
            'gambar_kategori.image'    => 'File harus berupa gambar.',
            'gambar_kategori.mimes'    => 'Format gambar harus jpeg, png, jpg, atau webp.',
            'gambar_kategori.max'      => 'Ukuran gambar maksimal 5MB.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()->toArray(),
            ], 422);
        }

        try {
            $data = $request->only(['nama_kategori']);

            if ($request->hasFile('gambar_kategori')) {
                $data['gambar_kategori'] = $request->file('gambar_kategori')->store('kategori', 'public');
            }

            Kategori::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil ditambahkan!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Perbarui kategori.
     */
    public function update(Request $request, Kategori $kategori)
    {
        $validator = Validator::make($request->all(), [
            'nama_kategori'   => 'required|string|max:100|unique:kategori,nama_kategori,' . $kategori->id_kategori . ',id_kategori',
            'gambar_kategori' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ], [
            'nama_kategori.required'   => 'Nama kategori wajib diisi.',
            'nama_kategori.max'        => 'Nama kategori maksimal 100 karakter.',
            'nama_kategori.unique'     => 'Nama kategori sudah ada.',
            'gambar_kategori.image'    => 'File harus berupa gambar.',
            'gambar_kategori.mimes'    => 'Format gambar harus jpeg, png, jpg, atau webp.',
            'gambar_kategori.max'      => 'Ukuran gambar maksimal 5MB.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()->toArray(),
            ], 422);
        }

        try {
            $data = $request->only(['nama_kategori']);

            // ── Kasus 1: User upload gambar baru → ganti gambar lama ──
            if ($request->hasFile('gambar_kategori')) {
                // Hapus gambar lama dari storage
                if ($kategori->gambar_kategori) {
                    Storage::disk('public')->delete($kategori->gambar_kategori);
                }
                $data['gambar_kategori'] = $request->file('gambar_kategori')->store('kategori', 'public');
            }
            // ── Kasus 2: User klik "Hapus Gambar" → hapus gambar lama ──
            elseif ($request->filled('remove_gambar') && $request->remove_gambar == '1') {
                if ($kategori->gambar_kategori) {
                    Storage::disk('public')->delete($kategori->gambar_kategori);
                }
                $data['gambar_kategori'] = null;
            }
            // ── Kasus 3: User tidak ubah gambar → biarkan apa adanya ──
            // Tidak perlu isi $data['gambar_kategori'], tidak di-touch

            $kategori->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil diperbarui!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Hapus kategori.
     */
    public function destroy(Kategori $kategori)
    {
        try {
            // Cek apakah kategori masih memiliki produk
            $produkCount = $kategori->produks()->count();

            if ($produkCount > 0) {
                return response()->json([
                    'success' => false,
                    'message' => "Kategori tidak dapat dihapus karena masih memiliki {$produkCount} produk. Pindahkan atau hapus produk terlebih dahulu.",
                ], 422);
            }

            // Hapus gambar dari storage
            if ($kategori->gambar_kategori) {
                Storage::disk('public')->delete($kategori->gambar_kategori);
            }

            $kategori->delete();

            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil dihapus!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }
}