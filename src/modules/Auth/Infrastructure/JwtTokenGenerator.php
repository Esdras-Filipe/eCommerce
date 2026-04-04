<?php

namespace Modules\Auth\Infrastructure;

use Modules\Auth\Domain\User;
use Modules\Auth\Domain\TokenGeneratorInterface;
use Firebase\JWT\JWT;

class JwtTokenGenerator implements TokenGeneratorInterface
{
    public function generate(User $user): string
    {
        $payload = [
            'sub'   => $user->id,
            'email' => $user->email,
            'role'  => $user->role,
            'iat'   => time(),
            'exp'   => time() + (60 * 60 * 8), // 8 horas
        ];

        return JWT::encode($payload, config('app.key'), 'HS256');
    }
}
