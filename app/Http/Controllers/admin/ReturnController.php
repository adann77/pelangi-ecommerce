<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Retur;
use Illuminate\Http\Request;

class ReturnController extends Controller
{
    /**
     * Display listing of retur with filtering & search
     */
    public function index(Request $request)
    {
        $query = Retur::with(['user', 'pesanan', 'produk']);

        // Filter by status
        $status = $request->get('status', 'semua');
        $statusMap = [
            'menunggu' => 'pending',
            'diproses' => 'diproses',
            'selesai'  => 'selesai',
            'ditolak'  => 'ditolak',
        ];

        if ($status !== 'semua' && isset($statusMap[$status])) {
            $query->where('status_return', $statusMap[$status]);
        }

        // Search
        $search = $request->get('search');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('id_return', 'LIKE', "%{$search}%")
                  ->orWhere('alasan_return', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function ($q2) use ($search) {
                      $q2->where('nama', 'LIKE', "%{$search}%")
                         ->orWhere('email', 'LIKE', "%{$search}%");
                  })
                  ->orWhereHas('produk', function ($q2) use ($search) {
                      $q2->where('nama_produk', 'LIKE', "%{$search}%");
                  });
            });
        }

        $returs = $query->orderBy('tanggal_pengajuan', 'desc')->paginate(10);

        // Counts for tabs
        $counts = [
            'semua'     => Retur::count(),
            'menunggu'  => Retur::where('status_return', 'pending')->count(),
            'diproses'  => Retur::where('status_return', 'diproses')->count(),
            'selesai'   => Retur::where('status_return', 'selesai')->count(),
            'ditolak'   => Retur::where('status_return', 'ditolak')->count(),
        ];

        // Statistics
        $stats = [
            'avg_response'    => $this->getAvgResponseTime(),
            'approval_rate'   => $this->getApprovalRate(),
            'returns_this_week' => Retur::whereBetween('tanggal_pengajuan', [
                now()->startOfWeek(),
                now()->endOfWeek(),
            ])->count(),
        ];

        return view('admin.retur', compact('returs', 'counts', 'stats', 'status', 'search'));
    }

    /**
     * Get retur detail for modal (AJAX)
     */
    public function show($id)
    {
        $retur = Retur::with(['user', 'pesanan', 'produk'])->findOrFail($id);

        return response()->json([
            'id_return'          => $retur->id_return,
            'kode_return'        => $retur->kode_return,
            'alasan_return'      => $retur->alasan_return,
            'bukti_return_url'   => $retur->bukti_return_url,
            'status_return'      => $retur->status_return,
            'status_label'       => $retur->status_label,
            'status_color'       => $retur->status_color,
            'tanggal_pengajuan'  => $retur->tanggal_pengajuan->format('d M Y, H:i'),
            'catatan_admin'      => $retur->catatan_admin,
            'user' => [
                'nama'   => $retur->user->nama ?? '-',
                'email'  => $retur->user->email ?? '-',
                'no_hp'  => $retur->user->no_hp ?? '-',
                'alamat' => $retur->user->alamat ?? '-',
            ],
            'pesanan' => [
                'id_pesanan'       => $retur->pesanan->id_pesanan ?? null,
                'kode_pesanan'     => '#PSN-' . str_pad($retur->pesanan->id_pesanan ?? 0, 3, '0', STR_PAD_LEFT),
                'tanggal_pesanan'  => $retur->pesanan ? $retur->pesanan->tanggal_pesanan->format('d M Y, H:i') : '-',
                'total_harga'      => $retur->pesanan ? 'Rp ' . number_format($retur->pesanan->total_harga, 0, ',', '.') : '-',
                'status_pesanan'   => $retur->pesanan->status_pesanan ?? '-',
            ],
            'produk' => [
                'nama_produk'  => $retur->produk->nama_produk ?? '-',
                'harga'        => $retur->produk ? 'Rp ' . number_format($retur->produk->harga, 0, ',', '.') : '-',
                'gambar_url'   => $retur->produk->gambar_produk ? asset('storage/' . $retur->produk->gambar_produk) : null,
            ],
        ]);
    }

    /**
     * Approve a pending retur → status becomes 'diproses'
     */
    public function approve($id)
    {
        $retur = Retur::findOrFail($id);

        if ($retur->status_return !== 'pending') {
            return response()->json([
                'error' => 'Hanya retur dengan status Menunggu yang dapat disetujui.'
            ], 400);
        }

        $retur->update(['status_return' => 'diproses']);

        return response()->json([
            'success' => 'Retur ' . $retur->kode_return . ' berhasil disetujui dan sedang diproses.'
        ]);
    }

    /**
     * Reject a pending retur → status becomes 'ditolak'
     */
    public function reject(Request $request, $id)
    {
        $retur = Retur::findOrFail($id);

        if ($retur->status_return !== 'pending') {
            return response()->json([
                'error' => 'Hanya retur dengan status Menunggu yang dapat ditolak.'
            ], 400);
        }

        $retur->update([
            'status_return' => 'ditolak',
            'catatan_admin' => $request->catatan_admin,
        ]);

        return response()->json([
            'success' => 'Retur ' . $retur->kode_return . ' berhasil ditolak.'
        ]);
    }

    /**
     * Complete a processed retur → status becomes 'selesai'
     */
    public function complete($id)
    {
        $retur = Retur::findOrFail($id);

        if ($retur->status_return !== 'diproses') {
            return response()->json([
                'error' => 'Hanya retur yang sedang Diproses yang dapat diselesaikan.'
            ], 400);
        }

        $retur->update(['status_return' => 'selesai']);

        return response()->json([
            'success' => 'Retur ' . $retur->kode_return . ' berhasil diselesaikan.'
        ]);
    }

    /**
     * Export retur data as CSV
     */
    public function export()
    {
        $returs = Retur::with(['user', 'pesanan', 'produk'])
            ->orderBy('tanggal_pengajuan', 'desc')
            ->get();

        $filename = 'data_retur_' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($returs) {
            $file = fopen('php://output', 'w');
            // BOM for Excel UTF-8 compatibility
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, ['ID Retur', 'Pelanggan', 'Email', 'Produk', 'ID Pesanan', 'Alasan', 'Status', 'Catatan Admin', 'Tanggal Pengajuan']);

            foreach ($returs as $r) {
                fputcsv($file, [
                    $r->kode_return,
                    $r->user->nama ?? '-',
                    $r->user->email ?? '-',
                    $r->produk->nama_produk ?? '-',
                    '#PSN-' . str_pad($r->id_pesanan, 3, '0', STR_PAD_LEFT),
                    $r->alasan_return,
                    $r->status_label,
                    $r->catatan_admin ?? '-',
                    $r->tanggal_pengajuan->format('d M Y H:i'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // ========== PRIVATE HELPERS ==========

    private function getAvgResponseTime()
    {
        $result = Retur::where('status_return', '!=', 'pending')
            ->selectRaw('AVG(TIMESTAMPDIFF(HOUR, tanggal_pengajuan, updated_at)) as avg_hours')
            ->first();

        return $result && $result->avg_hours ? round($result->avg_hours, 1) : 0;
    }

    private function getApprovalRate()
    {
        $total   = Retur::where('status_return', '!=', 'pending')->count();
        $approved = Retur::whereIn('status_return', ['diproses', 'selesai'])->count();

        return $total > 0 ? round(($approved / $total) * 100, 1) : 0;
    }
}