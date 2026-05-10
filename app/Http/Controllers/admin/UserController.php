<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role') && $request->role !== 'semua') {
            $query->where('role', $request->role);
        }

        $users = $query->paginate(10);

        return view('admin.users', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role'     => 'required|in:admin,reseller,customer',
            'no_hp'    => 'nullable|string|max:15',
            'alamat'   => 'nullable|string',
        ]);

        User::create([
            'nama'     => $validated['nama'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => $validated['role'],
            'no_hp'    => $validated['no_hp'] ?? null,
            'alamat'   => $validated['alamat'] ?? null,
            'status'   => 'aktif',
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'nama'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email,' . $id . ',id_user',
            'password' => 'nullable|min:6',
            'role'     => 'required|in:admin,reseller,customer',
            'no_hp'    => 'nullable|string|max:15',
            'alamat'   => 'nullable|string',
        ]);

        // ✅ FIX: Assign field satu-per-satu — tidak ada risiko mass assignment
        $user->nama   = $validated['nama'];
        $user->email  = $validated['email'];
        $user->role   = $validated['role'];
        $user->no_hp  = $validated['no_hp'] ?? null;
        $user->alamat = $validated['alamat'] ?? null;

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Data user berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id_user === auth()->id()) {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak bisa menghapus akun sendiri!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus!');
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);

        $user->status = $user->status === 'aktif' ? 'suspen' : 'aktif';
        $user->save();

        $statusText = $user->status === 'aktif' ? 'diaktifkan' : 'disuspend';

        return redirect()->route('admin.users.index')->with('success', "User berhasil {$statusText}!");
    }
}