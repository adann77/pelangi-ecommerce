<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\PendaftaranReseller;
use App\Http\Controllers\admin\ProdukController;
use App\Http\Controllers\admin\KategoriController;
use App\Http\Controllers\admin\PesananController;
use App\Http\Controllers\admin\PengirimanController;
use App\Http\Controllers\admin\ReturnController;
use App\Http\Controllers\admin\RatingController;
use App\Http\Controllers\admin\ResellerController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\LaporanController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\CheckOutController;
use App\Http\Controllers\admin\ResellerController as AdminResellerController;
use App\Http\Controllers\PembayaranController;


/*
|--------------------------------------------------------------------------
| Home & Public Pages  (bisa diakses guest)
|--------------------------------------------------------------------------
*/

Route::get('/',        [HomeController::class, 'index'])    ->name('home');
Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog');

// ✅ BARU: Route Detail Produk (Bisa diakses tanpa login)
Route::get('/produk/{id}', [KatalogController::class, 'detail'])->name('produk.detail');

Route::get('/about',  fn () => view('about'))              ->name('about');

/*
|--------------------------------------------------------------------------
| Pendaftaran Reseller  (WAJIB LOGIN)
|--------------------------------------------------------------------------
|  Jika belum login → Laravel otomatis redirect ke /login
|  Setelah login berhasil → Laravel otomatis redirect kembali ke sini
|  karena middleware auth menyimpan URL tujuan di session "url.intended"
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    Route::get ('/pendaftaran-reseller',        [PendaftaranReseller::class, 'create' ])->name('reseller.register.form');
    Route::post('/pendaftaran-reseller',        [PendaftaranReseller::class, 'store'  ])->name('reseller.register.store');
    Route::get ('/pendaftaran-reseller/sukses', [PendaftaranReseller::class, 'success'])->name('reseller.register.success');

    Route::get   ('/keranjang',        [KeranjangController::class, 'index'  ])->name('keranjang.index');
    Route::post  ('/keranjang',        [KeranjangController::class, 'store'  ])->name('keranjang.store');
    Route::put   ('/keranjang/{id}',   [KeranjangController::class, 'update' ])->name('keranjang.update');
    Route::delete('/keranjang/{id}',   [KeranjangController::class, 'destroy'])->name('keranjang.destroy');
    Route::delete('/keranjang-clear',  [KeranjangController::class, 'clear'  ])->name('keranjang.clear');

    Route::get('/checkout', [CheckOutController::class, 'index'])->name('checkout.index');
    Route::get('/pembayaran/{id_pesanan}', [PembayaranController::class, 'show'])->name('pembayaran.show');
    Route::post('/checkout/process', [CheckOutController::class, 'process'])->name('checkout.process');
});

/*
|--------------------------------------------------------------------------
| Dashboard Redirect (setelah login)
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    $user = auth()->user();

    return match ($user->role) {
        'admin'    => redirect()->route('admin.dashboard'),
        'reseller' => redirect()->route('reseller.dashboard'),
        default    => redirect()->route('customer.dashboard'),
    };
})->middleware(['auth'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', fn () => view('admin.dashboard'))->name('dashboard');

    // ── Produk CRUD ──
    Route::get   ('/produk',          [ProdukController::class, 'index'  ])->name('produk.index');
    Route::post  ('/produk',          [ProdukController::class, 'store'  ])->name('produk.store');
    Route::put   ('/produk/{produk}', [ProdukController::class, 'update' ])->name('produk.update');
    Route::delete('/produk/{produk}', [ProdukController::class, 'destroy'])->name('produk.destroy');
    


    // ── Kategori CRUD ──
    Route::get   ('/kategori',            [KategoriController::class, 'index'  ])->name('kategori.index');
    Route::post  ('/kategori',            [KategoriController::class, 'store'  ])->name('kategori.store');
    Route::put   ('/kategori/{kategori}', [KategoriController::class, 'update' ])->name('kategori.update');
    Route::delete('/kategori/{kategori}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

    // ── Pesanan CRUD ──
    Route::get('/pesanan',      [PesananController::class, 'index'])->name('pesanan.index');
    Route::get('/pesanan/{id}', [PesananController::class, 'show'])->name('pesanan.show');
    Route::put('/pesanan/{id}', [PesananController::class, 'update'])->name('pesanan.update');

    Route::resource('pengiriman', PengirimanController::class);

    // ── Retur ──
    Route::get ('/retur',                [ReturnController::class, 'index'   ])->name('retur.index');
    Route::get ('/retur/{id}',           [ReturnController::class, 'show'    ])->name('retur.show');
    Route::put ('/retur/{id}/approve',   [ReturnController::class, 'approve' ])->name('retur.approve');
    Route::put ('/retur/{id}/reject',    [ReturnController::class, 'reject'  ])->name('retur.reject');
    Route::put ('/retur/{id}/complete',  [ReturnController::class, 'complete'])->name('retur.complete');
    Route::get ('/retur-export',         [ReturnController::class, 'export'  ])->name('retur.export');

    // ── Rating ──
    Route::get('/rating',              [RatingController::class, 'index'       ])->name('rating.index');
    Route::put('/rating/{id}/toggle',  [RatingController::class, 'toggleStatus'])->name('rating.toggleStatus');
    Route::delete('/rating/{id}',      [RatingController::class, 'destroy'     ])->name('rating.destroy');

    // Reseller Management
    Route::get('/reseller',                [ResellerController::class, 'index'  ])->name('reseller.index');
    Route::get('/reseller/{id}',           [ResellerController::class, 'show'   ])->name('reseller.show');
    Route::put('/reseller/{id}/approve',   [ResellerController::class, 'approve'])->name('reseller.approve');
    Route::put('/reseller/{id}/reject',    [ResellerController::class, 'reject' ])->name('reseller.reject');
    Route::put('/admin/reseller/{id_user}/approve', [AdminResellerController::class, 'approve'])->name('admin.reseller.approve');
    Route::put('/admin/reseller/{id_user}/reject', [AdminResellerController::class, 'reject'])->name('admin.reseller.reject');
    // ── User Management ──
    Route::get   ('/users',                    [UserController::class, 'index'      ])->name('users.index');
    Route::post  ('/users',                    [UserController::class, 'store'      ])->name('users.store');
    Route::put   ('/users/{id}',               [UserController::class, 'update'     ])->name('users.update');
    Route::delete('/users/{id}',               [UserController::class, 'destroy'    ])->name('users.destroy');
    Route::put   ('/users/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');

    // ── Laporan ──
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');
    
    
});

/*
|--------------------------------------------------------------------------
| Reseller Routes  (hanya untuk role reseller)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('reseller')->name('reseller.')->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->role !== 'reseller') {
            abort(403);
        }
        return view('reseller.dashboard');
    })->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| Customer Routes  (hanya untuk role customer)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->role !== 'customer') {
            abort(403);
        }
        return view('customer.dashboard');
    })->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get   ('/profile', [ProfileController::class, 'edit'   ])->name('profile.edit');
    Route::patch ('/profile', [ProfileController::class, 'update' ])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Auth Routes  (login, register, logout, dll)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';