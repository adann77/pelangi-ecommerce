<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\KeranjangDetail;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    // public function boot(): void
    // {
    //     //
    // }
     public function boot(): void
    {
        // Share jumlah item keranjang ke semua view
        View::composer('*', function ($view) {
            $cartCount = 0;
            if (auth()->check()) {
                $cartCount = KeranjangDetail::whereHas('keranjang', function ($query) {
                    $query->where('id_user', auth()->id());
                })->sum('kuantitas');
            }
            $view->with('cartCount', $cartCount);
        });
    }
}
