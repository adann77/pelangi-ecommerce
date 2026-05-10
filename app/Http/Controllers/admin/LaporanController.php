<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\User;
use App\Models\Produk;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // 1. Total Pendapatan (Pesanan dengan status selesai)
        $totalPendapatan = Pesanan::where('status_pesanan', 'selesai')->sum('total_harga');

        // 2. Total Transaksi (Semua transaksi)
        $totalTransaksi = Pesanan::count();

        // 3. Produk Terlaris (Sebagai fallback karena detail_pesanan tidak ada, ambil produk stok terendah/terlaris)
        $produkTerlaris = Produk::orderBy('stok', 'asc')->first();

        // 4. Pelanggan Aktif (Role customer & reseller dengan status aktif)
        $pelangganAktif = User::whereIn('role', ['customer', 'reseller'])
                              ->where('status', 'aktif' ?? 'aktif') 
                              ->count();

        // 5. Tabel Data Transaksi
        $query = Pesanan::with('user')->latest('tanggal_pesanan');

        // Fitur Filter: Pencarian ID Transaksi atau Nama Pelanggan
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id_pesanan', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('nama', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Fitur Filter: Rentang Tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_pesanan', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        $pesanan = $query->paginate(10);

        return view('admin.laporan', compact(
            'totalPendapatan',
            'totalTransaksi',
            'produkTerlaris',
            'pelangganAktif',
            'pesanan'
        ));
    }
}