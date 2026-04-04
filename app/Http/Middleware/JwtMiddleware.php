<?php

namespace App\Http\Middleware;

use Modules\Auth\Domain\TokenGeneratorInterface;
use Closure;
use Modules\User\Domain\User;

class JwtMiddleware
{
    public function __construct(private TokenGeneratorInterface $tokenGenerator) {}

    public function handle($request, Closure $next)
    {
        $authHeader = $request->header('Authorization');

        if (!$authHeader) {
            return response()->json(['message' => 'Token não informado'], 401);
        }

        $token = str_replace('Bearer ', '', $authHeader);

        try {
            $decoded    = $this->tokenGenerator->validateToken($token);
            $userLogged = new User(id: $decoded->sub, role: $decoded->role, email: $decoded->email, passwordHash: '', name: '');

            $request->attributes->set('auth_user', $userLogged);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Token inválido'], 401);
        }

        return $next($request);
    }
}
