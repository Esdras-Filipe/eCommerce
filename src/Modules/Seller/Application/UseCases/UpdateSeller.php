<?php

namespace Modules\Seller\Application\UseCases;

use Illuminate\Support\Str;

use Modules\Seller\Domain\Exceptions\SellerNotExistsException;

use Modules\Seller\Application\DTOs\UpdateSellerDTO;
use Modules\Seller\Domain\Seller;
use Modules\Seller\Domain\SellerRepositoryInterface;

class UpdateSeller
{
    public function __construct(private SellerRepositoryInterface $seller) {}

    public function execute(UpdateSellerDTO $dto): Seller
    {
        $currentSeller = $this->seller->findById($dto->id);
        if (!$currentSeller) {
            throw new SellerNotExistsException();
        }

        $seller = new Seller(
            id: $currentSeller->id,
            name: $dto->name ?? $dto->name,
            slug: $currentSeller->slug,
            email: $currentSeller->email,
            password: $currentSeller->password,
            document: $currentSeller->document,
            is_active: $currentSeller->is_active,
            is_verified: $currentSeller->is_verified,
            logo_url: $dto->logo_url ?? $currentSeller->logo_url,
            banner_url: $dto->banner_url ?? $currentSeller->banner_url,
            description: $dto->description ?? $currentSeller->description,
            currency: $currentSeller->currency,
        );

        return $this->seller->update($seller);
    }
}
