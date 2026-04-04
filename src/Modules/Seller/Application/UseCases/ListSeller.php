<?php

namespace Modules\Seller\Application\UseCases;

use Modules\Seller\Application\DTOs\ListSellerDTO;
use Modules\Seller\Domain\SellerRepositoryInterface;

class ListSeller
{
    public function __construct(private SellerRepositoryInterface $sellers) {}

    public function execute(ListSellerDTO $dto): UserCollectionDTO
    {
        $users = $this->sellers->search($dto);

        return new UserCollectionDTO(
            items: $users->items(),
            total: $users->total(),
            perPage: $users->perPage(),
            currentPage: $users->currentPage()
        );
    }
}
