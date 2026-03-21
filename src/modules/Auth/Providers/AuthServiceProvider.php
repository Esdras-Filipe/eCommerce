<?php

namespace Modules\Auth\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Auth\Domain\UserRepositoryInterface;
use Modules\Auth\Domain\TokenGeneratorInterface;
use Modules\Auth\Infrastructure\EloquentUserRepository;
use Modules\Auth\Infrastructure\JwtTokenGenerator;
use Illuminate\Support\Facades\Route;

class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');

        Route::middleware('api')
            ->prefix('api')
            ->group(base_path('src/modules/Auth/routes/api.php'));
    }

    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);
        $this->app->bind(TokenGeneratorInterface::class, JwtTokenGenerator::class);
    }
}
