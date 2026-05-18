<?php

namespace App\Providers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Voucher;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

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
    public function boot(): void
    {
        // untuk mengatasi type hint yang string bukan class name
        Relation::enforceMorphMap([
            "customer" => Customer::class,
            "product" => Product::class,
            "voucher" => Voucher::class,
        ]);
    }
}
