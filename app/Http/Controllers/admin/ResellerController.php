<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ResellerController extends Controller
{
    public function index()
    {
        $resellers = User::where('role', 'reseller')
                        ->orWhereNotNull('status_reseller')
                        ->latest()
                        ->get();

        $total = $resellers->count();
        // Null juga dianggap pending
        $pending = $resellers->where('status_reseller', 'pending')
                             ->merge($resellers->where('status_reseller', null))
                             ->count();
        $approved = $resellers->where('status_reseller', 'approved')->count();

        return view('admin.reseller', compact('resellers', 'total', 'pending', 'approved'));
    }

    public function show($id)
    {
        $reseller = User::findOrFail($id);
        return response()->json($reseller);
    }

    // public function approve($id)
    // {
    //     $reseller = User::findOrFail($id);
    //     $reseller->status_reseller = 'approved';
    //     $reseller->role = 'reseller';
    //     $reseller->save();

    //     return redirect()->back()->with('success', 'Reseller berhasil disetujui!');
    // }

    public function approve($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $user->update([
            'role'            => 'reseller',   // ← role baru berubah di sini
            'status_reseller' => 'approved',
        ]);
        return back()->with('success', 'Pendaftaran reseller disetujui.');
    }
    // public function reject($id)
    // {
    //     $reseller = User::findOrFail($id);
    //     $reseller->status_reseller = 'rejected';
    //     $reseller->save();

    //     return redirect()->back()->with('success', 'Pendaftar reseller berhasil ditolak.');
    // }
    public function reject($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $user->update([
            'role'            => 'customer',   // tetap customer
            'status_reseller' => 'rejected',
        ]);
        return back()->with('success', 'Pendaftaran reseller ditolak.');
    }
}