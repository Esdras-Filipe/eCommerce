<?php

namespace Modules\Seller\Application\UseCases;

use Modules\Seller\Domain\Exceptions\SellerNotExistsException;
use Modules\Seller\Application\DTOs\DeleteSellerDTO;
use Modules\Seller\Domain\Seller;
use Modules\Seller\Domain\SellerRepositoryInterface;

class DeleteSeller
{
    public function __construct(private SellerRepositoryInterface $seller) {}

    public function execute(DeleteSellerDTO $dto): bool
    {
        $currentSeller = $this->seller->findById($dto->id);
        if (!$currentSeller) {
            throw new SellerNotExistsException();
        }

        $seller = new Seller(
            id: $currentSeller->id,
            name: $currentSeller->name,
            slug: $currentSeller->slug,
            email: $currentSeller->email,
            password: $currentSeller->password,
            document: $currentSeller->document,
            is_active: $currentSeller->is_active,
            is_verified: $currentSeller->is_verified,
            logo_url: $currentSeller->logo_url,
            banner_url: $currentSeller->banner_url,
            description: $currentSeller->description,
            currency: $currentSeller->currency,
        );

        return $this->seller->delete($seller);
    }
}
