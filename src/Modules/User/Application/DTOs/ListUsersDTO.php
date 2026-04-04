<?php

namespace Modules\User\Application\DTOs;

class ListUsersDTO
{
    public function __construct(
        public ?string $name = null,
        public ?string $email = null,
        public ?string $role = null,
        public int $page = 1,
        public int $perPage = 15,
        public ?string $sortBy = null,
        public string $sortDirection = 'asc'
    ) {}
}
