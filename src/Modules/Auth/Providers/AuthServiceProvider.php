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
        Route::middleware('api')
            ->prefix('api')  // adicione isso de volta
            ->group(base_path('src/Modules/Auth/routes/api.php'));
    }

    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);
        $this->app->bind(TokenGeneratorInterface::class, JwtTokenGenerator::class);
    }
}
