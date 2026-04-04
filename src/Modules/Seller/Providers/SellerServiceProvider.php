<?php

namespace Modules\Seller\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Modules\Seller\Domain\SellerRepositoryInterface;
use Modules\Seller\Infrastructure\EloquentSellerRepository;

class SellerServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Route::middleware('api')
            ->prefix('api')
            ->group(base_path('src/Modules/Seller/Routes/api.php'));
    }

    public function register(): void
    {
        $this->app->bind(SellerRepositoryInterface::class, EloquentSellerRepository::class);
    }
}
