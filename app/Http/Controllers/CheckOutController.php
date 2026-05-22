<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;

// class CheckOutController extends Controller
// {
//     public function index()
//     {
//         $user = Auth::user();
        
//         // Ambil keranjang user yang sedang login
//         $keranjang = $user->keranjang()->with('details.produk', 'details.varian')->first();

//         // Jika keranjang kosong, redirect kembali ke keranjang dengan pesan error
//         if (!$keranjang || $keranjang->details->count() === 0) {
//             return redirect()->route('keranjang.index')->with('error', 'Keranjang Anda kosong, silakan tambahkan produk terlebih dahulu.');
//         }

//         return view('checkout', compact('keranjang'));
//     }

//     public function process(Request $request)
//     {
//         // Validasi input
//         $request->validate([
//             'nama_penerima' => 'required|string|max:255',
//             'no_telepon' => 'required|string|max:20',
//             'alamat_lengkap' => 'required|string',
//             'kota' => 'required|string|max:100',
//             'kode_pos' => 'required|string|max:10',
//             'metode_pembayaran' => 'required|string',
//             'kurir' => 'required|string',
//         ]);

//         // TODO: Logika menyimpan ke database (tabel orders/order_items)
//         // TODO: Kurangi stok produk
//         // TODO: Kosongkan keranjang setelah checkout berhasil

//         return redirect()->route('home')->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');
//     }
// }


namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Pembayaran;
use App\Models\Pengiriman;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckOutController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Ambil keranjang beserta relasi detail, produk, dan varian
        $keranjang = $user->keranjang()->with('details.produk', 'details.varian')->first();

        // Jika keranjang kosong, kembalikan ke halaman keranjang
        if (!$keranjang || $keranjang->details->isEmpty()) {
            return redirect()->route('keranjang.index')->with('error', 'Keranjang Anda kosong!');
        }

        return view('checkout', compact('keranjang'));
    }

    public function process(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_penerima' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:20',
            'alamat_lengkap' => 'required|string',
            'kota' => 'required|string|max:100',
            'kode_pos' => 'required|string|max:10',
            'metode_pembayaran' => 'required|string',
            'kurir' => 'required|string',
            'ongkir' => 'required|numeric',
        ]);

        $user = Auth::user();
        $keranjang = $user->keranjang()->with('details.produk', 'details.varian')->first();

        if (!$keranjang || $keranjang->details->isEmpty()) {
            return redirect()->route('keranjang.index')->with('error', 'Keranjang kosong!');
        }

        // Hitung total belanja
        $totalHarga = $keranjang->details->sum(function ($detail) {
            return $detail->kuantitas * ($detail->produk->harga ?? 0);
        });

        $totalBesar = $totalHarga + $request->ongkir;

        // Gunakan DB Transaction untuk menjaga integritas data
        try {
            DB::beginTransaction();

            // 1. Buat Pesanan
            $pesanan = Pesanan::create([
                'id_user' => $user->id,
                'total_harga' => $totalBesar,
                'status_pesanan' => 'menunggu_pembayaran', // Sesuaikan dengan enum/migrasi Anda
            ]);

            // 2. Simpan Detail Pesanan & Kurangi Stok
            foreach ($keranjang->details as $detail) {
                DetailPesanan::create([
                    'id_pesanan' => $pesanan->id_pesanan,
                    'id_produk' => $detail->id_produk,
                    'id_varian' => $detail->id_varian,
                    'kuantitas' => $detail->kuantitas,
                    'harga' => $detail->produk->harga ?? 0,
                ]);

                // Kurangi stok varian jika ada
                if ($detail->varian) {
                    $detail->varian->decrement('stok_varian', $detail->kuantitas);
                } else if($detail->produk) {
                    $detail->produk->decrement('stok', $detail->kuantitas);
                }
            }

            // 3. Simpan Data Pengiriman
            Pengiriman::create([
                'pesanan_id' => $pesanan->id_pesanan,
                'kurir' => $request->kurir,
                'ongkir' => $request->ongkir,
                'status' => Pengiriman::STATUS_PERLU_DIKIRIM,
            ]);

            // 4. Simpan Data Pembayaran
            Pembayaran::create([
                'id_pesanan' => $pesanan->id_pesanan,
                'metode_pembayaran' => $request->metode_pembayaran,
                'status_pembayaran' => 'pending',
            ]);

            // 5. Kosongkan Keranjang
            $keranjang->details()->delete();

            DB::commit();

            return redirect()->route('home')->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat memproses pesanan: ' . $e->getMessage());
        }
    }
}