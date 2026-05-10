@extends('layouts.admin')

@section('pageTitle', 'Manajemen Data Users — Pelangi Accessories Admin')

@section('nav-users', 'active')

@section('headerTitle', 'Data User')

@section('headerActions')
   
@endsection

@section('content')

@php
    $usersMap = $users->mapWithKeys(function ($u) {
        return [$u->id_user => [
            'id_user' => $u->id_user,
            'nama'    => $u->nama,
            'email'   => $u->email,
            'role'    => $u->role,
            'no_hp'   => $u->no_hp,
            'alamat'  => $u->alamat,
            'status'  => $u->status,
        ]];
    });
@endphp

<script type="application/json" id="users-json-data">{{ $usersMap->toJson() }}</script>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('userModal', {
            show: false,
            isEdit: false,
            user: { role: 'customer' },
            allUsers: {},

            init() {
                try {
                    const jsonEl = document.getElementById('users-json-data');
                    if (jsonEl) {
                        this.allUsers = JSON.parse(jsonEl.textContent);
                    }
                } catch (e) {
                    console.error("Gagal memuat data user:", e);
                }
            },

            open(userId = null) {
                if (userId && this.allUsers[userId]) {
                    this.isEdit = true;
                    this.user = { ...this.allUsers[userId] };
                } else {
                    this.isEdit = false;
                    this.user = {
                        id_user: '',
                        nama: '',
                        email: '',
                        role: 'customer',
                        no_hp: '',
                        alamat: '',
                    };
                }
                this.show = true;
            },

            close() {
                this.show = false;
            }
        });
    });
</script>

<div x-data>
    <!-- Flash Message -->
    @if(session('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
             x-transition.opacity
             class="mb-4 p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-sm text-emerald-700 flex items-center gap-2">
            <iconify-icon icon="lucide:check-circle" class="text-lg"></iconify-icon>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
             x-transition.opacity
             class="mb-4 p-4 bg-rose-50 border border-rose-200 rounded-xl text-sm text-rose-700 flex items-center gap-2">
            <iconify-icon icon="lucide:alert-circle" class="text-lg"></iconify-icon>
            {{ session('error') }}
        </div>
    @endif

    <!-- Validation Errors -->
    @if($errors->any())
        <div class="mb-4 p-4 bg-rose-50 border border-rose-200 rounded-xl text-sm text-rose-700">
            <div class="flex items-center gap-2 mb-2 font-medium">
                <iconify-icon icon="lucide:alert-triangle" class="text-lg"></iconify-icon>
                Terdapat kesalahan pada form:
            </div>
            <ul class="list-disc list-inside space-y-1 ml-6">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- <div x-data>
        <button @click="$store.userModal.open()"
                class="flex items-center gap-2 px-4 py-2.5 rounded-xl bg-gray-900 text-white text-sm font-medium hover:bg-gray-800 transition-all shadow-sm active:scale-[0.98]">
            <iconify-icon icon="lucide:plus" class="text-lg"></iconify-icon>
            Tambah User
        </button>
    </div> -->

    <!-- Search and Filter Bar -->
    <form action="{{ route('admin.users.index') }}" method="GET"
          class="bg-white p-2 rounded-2xl border border-gray-200 shadow-[0_1px_2px_rgba(0,0,0,0.02)] mb-6 flex flex-col sm:flex-row gap-2">
        <div class="relative flex-1">
            <iconify-icon icon="lucide:search" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-lg"></iconify-icon>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari nama atau email user..."
                   class="w-full pl-11 pr-4 py-2.5 bg-transparent text-sm focus:outline-none placeholder:text-gray-400 text-gray-900">
        </div>
        <div class="hidden sm:block w-px bg-gray-200 my-2"></div>
        <select name="role" onchange="this.form.submit()"
                class="px-4 py-2.5 bg-transparent text-sm focus:outline-none text-gray-600 cursor-pointer rounded-xl hover:bg-gray-50">
            <option value="semua" {{ request('role') == 'semua' ? 'selected' : '' }}>Semua Role</option>
            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="reseller" {{ request('role') == 'reseller' ? 'selected' : '' }}>Reseller</option>
            <option value="customer" {{ request('role') == 'customer' ? 'selected' : '' }}>Customer</option>
        </select>
    </form>

    <!-- Data Table -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-[0_1px_2px_rgba(0,0,0,0.02)] flex-1 flex flex-col overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/80 border-b border-gray-200">
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Nama</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Email</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Status</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Role</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">

                    @forelse($users as $u)
                    @php
                        $initials = collect(explode(' ', $u->nama))->take(2)->map(fn($w) => strtoupper(substr($w, 0, 1)))->join('');
                        $colors = ['purple', 'blue', 'emerald', 'rose', 'amber', 'indigo', 'cyan'];
                        $color = $colors[$u->id_user % count($colors)];
                    @endphp

                    <tr class="hover:bg-gray-50/60 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-{{ $color }}-50 flex items-center justify-center border border-{{ $color }}-100 shrink-0 text-xs font-bold text-{{ $color }}-600">
                                    {{ $initials }}
                                </div>
                                <span class="text-sm font-medium text-gray-900 whitespace-nowrap">{{ $u->nama }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4"><span class="text-sm text-gray-600 whitespace-nowrap">{{ $u->email }}</span></td>
                        <td class="px-6 py-4">
                            @if($u->status === 'aktif')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100/50 whitespace-nowrap">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-100/50 whitespace-nowrap">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Suspen
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($u->role === 'admin')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium bg-gray-900 text-white whitespace-nowrap">
                                    <iconify-icon icon="lucide:shield" class="text-[12px]"></iconify-icon> Admin
                                </span>
                            @elseif($u->role === 'reseller')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-100/50 whitespace-nowrap">
                                    <iconify-icon icon="lucide:store" class="text-[12px]"></iconify-icon> Reseller
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100/50 whitespace-nowrap">
                                    <iconify-icon icon="lucide:shopping-bag" class="text-[12px]"></iconify-icon> Customer
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">

                                <button @click="$store.userModal.open({{ $u->id_user }})"
                                        class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                    <iconify-icon icon="lucide:edit-2" class="text-[16px]"></iconify-icon>
                                </button>

                                <form action="{{ route('admin.users.toggleStatus', $u->id_user) }}" method="POST">
                                    @csrf @method('PUT')
                                    @if($u->status === 'aktif')
                                        <button type="submit" class="p-2 text-gray-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors" title="Suspen">
                                            <iconify-icon icon="lucide:x-circle" class="text-[16px]"></iconify-icon>
                                        </button>
                                    @else
                                        <button type="submit" class="p-2 text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors" title="Aktifkan">
                                            <iconify-icon icon="lucide:check-circle" class="text-[16px]"></iconify-icon>
                                        </button>
                                    @endif
                                </form>

                                <form action="{{ route('admin.users.destroy', $u->id_user) }}" method="POST"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-gray-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors" title="Hapus">
                                        <iconify-icon icon="lucide:trash-2" class="text-[16px]"></iconify-icon>
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-10 text-gray-400 text-sm">Data user tidak ditemukan.</td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        <!-- Pagination Footer -->
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50/50 flex flex-col sm:flex-row items-center justify-between gap-4 mt-auto">
            <span class="text-sm text-gray-500">
                Menampilkan <span class="font-medium text-gray-900">{{ $users->firstItem() ?? 0 }}-{{ $users->lastItem() ?? 0 }}</span>
                dari <span class="font-medium text-gray-900">{{ $users->total() }}</span> users
            </span>
            <div class="flex items-center gap-1.5">
                {{ $users->links('pagination::tailwind') }}
            </div>
        </div>
    </div>


    <!-- ===== MODAL ADD/EDIT USER ===== -->

    <style>[x-cloak] { display: none !important; }</style>

    <!-- Background Overlay -->
    <div x-cloak x-show="$store.userModal.show"
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/50 z-40" @click="$store.userModal.close()"></div>

    <!-- Modal Content -->
    <div x-cloak x-show="$store.userModal.show"
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
         class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden" @click.stop>

            <!-- Modal Header -->
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <h2 class="text-lg font-bold text-gray-900" x-text="$store.userModal.isEdit ? 'Edit User' : 'Tambah User Baru'"></h2>
                <button type="button" @click="$store.userModal.close()"
                        class="p-1 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100 transition-colors">
                    <iconify-icon icon="lucide:x" class="text-xl"></iconify-icon>
                </button>
            </div>

            {{-- ===================================================== --}}
            {{-- ✅ PERBAIKAN UTAMA:                                    --}}
            {{-- 1. Gunakan :action binding (bukan form.submit() manual) --}}
            {{-- 2. HAPUS @submit.prevent agar form submit secara native --}}
            {{-- 3. HAPUS hidden user_id (tidak dipakai controller)      --}}
            {{-- ===================================================== --}}
            <form id="user-form" method="POST"
                  :action="$store.userModal.isEdit && $store.userModal.user.id_user ? '/admin/users/' + $store.userModal.user.id_user : '/admin/users'"
                  class="p-6 space-y-4">

                @csrf

                {{-- Method spoofing PUT hanya saat edit --}}
                <template x-if="$store.userModal.isEdit">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <!-- Nama -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="nama" x-model="$store.userModal.user.nama" required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none text-sm">
                    @error('nama')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" x-model="$store.userModal.user.email" required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none text-sm">
                    @error('email')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Password
                        <span x-show="$store.userModal.isEdit" class="text-xs text-gray-400">(Kosongkan jika tidak diubah)</span>
                    </label>
                    <input type="password" name="password"
                           :required="!$store.userModal.isEdit"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none text-sm">
                    @error('password')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role & No. HP -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                        <select name="role" x-model="$store.userModal.user.role" required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none text-sm bg-white">
                            <option value="customer">Customer</option>
                            <option value="reseller">Reseller</option>
                            <option value="admin">Admin</option>
                        </select>
                        @error('role')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">No. WhatsApp</label>
                        <input type="text" name="no_hp" x-model="$store.userModal.user.no_hp"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none text-sm">
                        @error('no_hp')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Alamat -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                    <textarea name="alamat" x-model="$store.userModal.user.alamat" rows="3"
                              class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none text-sm resize-none"></textarea>
                    @error('alamat')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Actions -->
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" @click="$store.userModal.close()"
                            class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                            class="px-5 py-2.5 text-sm font-medium text-white bg-gray-900 hover:bg-gray-800 rounded-xl transition-colors shadow-sm">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

@endsection