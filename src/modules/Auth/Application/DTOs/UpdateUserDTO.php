<?php

namespace Modules\Auth\Application\DTOs;

class UpdateUserDTO
{
    public function __construct(
        public readonly string $id,
        public readonly ?string $name = null,
        public readonly ?string $email = null,
        public readonly ?string $email_verified_at = null,
        public readonly ?string $role = null,
        public readonly ?string $remember_token = null,
    ) {}
}
