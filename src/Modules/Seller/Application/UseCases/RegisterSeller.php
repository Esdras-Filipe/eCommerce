<?php

namespace Modules\Seller\Application\UseCases;

use Illuminate\Support\Str;

use Modules\Seller\Domain\Exceptions\SellerAlreadyExistsException;
use Modules\Seller\Domain\Exceptions\SellerEmailAlreadyExistsException;
use Modules\Seller\Domain\Exceptions\SellerSlugAlreadyExistsException;

use Modules\Seller\Application\DTOs\RegisterSellerDTO;
use Modules\Seller\Domain\Seller;
use Modules\Seller\Domain\SellerRepositoryInterface;

class RegisterSeller
{
    public function __construct(private SellerRepositoryInterface $seller) {}

    public function execute(RegisterSellerDTO $dto): Seller
    {
        $user = $this->seller->findByDocument($dto->document);
        if ($user) {
            throw new SellerAlreadyExistsException();
        }

        $user = $this->seller->findByEmail($dto->email);
        if ($user) {
            throw new SellerEmailAlreadyExistsException();
        }

        $user = $this->seller->findBySlug($dto->slug);
        if ($user) {
            throw new SellerSlugAlreadyExistsException();
        }

        $seller = new Seller(
            id: Str::uuid()->toString(),
            name: $dto->name,
            slug: $dto->slug,
            email: $dto->email,
            password: $dto->password,
            document: $dto->document,
            is_active: false,
            is_verified: false,
            logo_url: $dto->logo_url,
            banner_url: $dto->banner_url,
            description: $dto->description,
            currency: $dto->currency,
        );

        return $this->seller->save($seller);
    }
}
