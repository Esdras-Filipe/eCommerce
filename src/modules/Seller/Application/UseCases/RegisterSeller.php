<?php

namespace Modules\Seller\Application\UseCases;

use Modules\Auth\Application\DTOs\RegisterUserDTO;
use Modules\Auth\Domain\UserRepositoryInterface;
use Modules\Auth\Domain\User;
use Illuminate\Support\Str;

use Modules\seller\Domain\Exceptions\SellerAlreadyExistsException;
use Modules\Seller\Application\DTOs\RegisterSellerDTO;
use Modules\Seller\Domain\SellerRepositoryInterface;

class RegisterSeller
{
    public function __construct(private SellerRepositoryInterface $seller) {}

    public function execute(RegisterSellerDTO $dto)
    {
        $user = $this->seller->findByCnpj($dto->id);

        if ($user) {
            throw new SellerAlreadyExistsException();
        }

        // $user = new User(
        //     id: Str::uuid()->toString(),
        //     name: $dto->name,
        //     email: $dto->email,
        //     passwordHash: password_hash($dto->password, PASSWORD_BCRYPT),
        //     role: 'customer',
        // );

        // return $this->users->save($user);
    }
}
