<?php

namespace Modules\Seller\Application\DTOs;

class SellerCollectionDTO
{
    public function __construct(
        public array $items,
        public int $total,
        public int $perPage,
        public int $currentPage
    ) {}
}
