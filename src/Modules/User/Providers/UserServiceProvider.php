<?php

namespace Modules\User\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\User\Domain\UserRepositoryInterface;
use Modules\User\Domain\TokenGeneratorInterface;
use Modules\User\Infrastructure\EloquentUserRepository;
use Modules\User\Infrastructure\JwtTokenGenerator;
use Illuminate\Support\Facades\Route;

class UserServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Route::middleware('api')
            ->prefix('api')
            ->group(base_path('src/Modules/User/routes/api.php'));
    }

    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);
    }
}
