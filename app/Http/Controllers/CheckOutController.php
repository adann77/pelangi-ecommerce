<?php

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
        
        $keranjang = $user->keranjang()->with('details.produk', 'details.varian')->first();

        if (!$keranjang || $keranjang->details->isEmpty()) {
            return redirect()->route('keranjang.index')->with('error', 'Keranjang Anda kosong!');
        }

        return view('checkout', compact('keranjang'));
    }

    public function process(Request $request)
    {
        // Validasi input — metode_pembayaran hanya menerima QRIS
        $request->validate([
            'nama_penerima' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:20',
            'alamat_lengkap' => 'required|string',
            'kota' => 'required|string|max:100',
            'kode_pos' => 'required|string|max:10',
            'metode_pembayaran' => 'required|string|in:QRIS',
            'kurir' => 'required|string',
            'ongkir' => 'required|numeric',
        ]);

        $user = Auth::user();
        $keranjang = $user->keranjang()->with('details.produk', 'details.varian')->first();

        if (!$keranjang || $keranjang->details->isEmpty()) {
            return redirect()->route('keranjang.index')->with('error', 'Keranjang kosong!');
        }

        $totalHarga = $keranjang->details->sum(function ($detail) {
            return $detail->kuantitas * ($detail->produk->harga ?? 0);
        });

        $totalBesar = $totalHarga + $request->ongkir;

        try {
            DB::beginTransaction();

            // 1. Buat Pesanan
            // $pesanan = Pesanan::create([
            //     'id_user' => $user->id,
            //     'total_harga' => $totalBesar,
            //     'status_pesanan' => 'menunggu_pembayaran',
            // ]);

            // 1. Buat Pesanan
          $alamatLengkap = $request->nama_penerima . ' | ' 
            . $request->no_telepon . ' | ' 
            . $request->alamat_lengkap . ', ' 
            . $request->kota . ' ' 
            . $request->kode_pos;

        $pesanan = Pesanan::create([
            'id_user'           => $user->id_user,
            'total_harga'       => $totalBesar,
            'status_pesanan'    => 'menunggu_pembayaran',
            'alamat_pengiriman' => $alamatLengkap,
            'layanan_kurir'     => $request->kurir,
            'ongkir'            => $request->ongkir,
        ]);
            // 2. Simpan Detail Pesanan & Kurangi Stok
            // foreach ($keranjang->details as $detail) {
            //     DetailPesanan::create([
            //         'id_pesanan' => $pesanan->id_pesanan,
            //         'id_produk' => $detail->id_produk,
            //         'id_varian' => $detail->id_varian,
            //         'kuantitas' => $detail->kuantitas,
            //         'harga' => $detail->produk->harga ?? 0,
            //     ]);

            //     if ($detail->varian) {
            //         $detail->varian->decrement('stok_varian', $detail->kuantitas);
            //     } else if($detail->produk) {
            //         $detail->produk->decrement('stok', $detail->kuantitas);
            //     }
            // }

            foreach ($keranjang->details as $detail) {
    $harga = $detail->produk->harga ?? 0;
    $qty   = $detail->kuantitas;

    DetailPesanan::create([
        'id_pesanan'   => $pesanan->id_pesanan,
        'id_produk'    => $detail->id_produk,
        'id_varian'    => $detail->id_varian ?? null,
        'harga_satuan' => $harga,           // ← nama kolom yang benar
        'kuantitas'    => $qty,
        'subtotal'     => $harga * $qty,    // ← hitung subtotal
    ]);

    // Kurangi stok
    if ($detail->varian) {
        $detail->varian->decrement('stok_varian', $qty);
    } elseif ($detail->produk) {
        $detail->produk->decrement('stok', $qty);
    }
}
            // 3. Simpan Data Pengiriman
            Pengiriman::create([
                'pesanan_id' => $pesanan->id_pesanan,
                'kurir' => $request->kurir,
                'ongkir' => $request->ongkir,
                'status' => Pengiriman::STATUS_PERLU_DIKIRIM,
            ]);

            // 4. Simpan Data Pembayaran — Selalu QRIS
            Pembayaran::create([
                'id_pesanan' => $pesanan->id_pesanan,
                'metode_pembayaran' => 'QRIS',
                'status_pembayaran' => 'pending',
            ]);

            // 5. Kosongkan Keranjang
            $keranjang->details()->delete();

            DB::commit();

            return redirect()->route('pembayaran.show', $pesanan->id_pesanan)
                ->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran via QRIS.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat memproses pesanan: ' . $e->getMessage());
        }
    }
}