<?php

namespace Modules\Auth\Domain;

class User
{
    public function __construct(
        public readonly string $id,
        public readonly string $email,
        public readonly string $name,
        public readonly string $passwordHash,
        public readonly string $role,
        public readonly ?string $email_verified_at = null,
        public readonly ?string $remember_token = null,
    ) {}

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->passwordHash);
    }
}
