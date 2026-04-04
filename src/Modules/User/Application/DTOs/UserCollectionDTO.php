<?php

namespace Modules\User\Application\DTOs;

class UserCollectionDTO
{
    public function __construct(
        public array $items,
        public int $total,
        public int $perPage,
        public int $currentPage
    ) {}
}
