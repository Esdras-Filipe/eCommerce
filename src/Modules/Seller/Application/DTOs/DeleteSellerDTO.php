<?php

namespace Modules\Seller\Application\DTOs;

class DeleteSellerDTO
{
    public function __construct(
        public readonly string $id
    ) {}
}
