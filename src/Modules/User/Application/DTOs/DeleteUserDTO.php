<?php

namespace Modules\User\Application\DTOs;

class DeleteUserDTO
{
    public function __construct(
        public readonly string $id,
    ) {}
}
