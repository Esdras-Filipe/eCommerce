<?php

namespace Modules\Seller\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class SellerServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Route::middleware('api')
            ->prefix('api')
            ->group(base_path('src/modules/Seller/routes/api.php'));
    }

    public function register(): void {}
}
