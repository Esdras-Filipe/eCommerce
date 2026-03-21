<?php

namespace Modules\Auth\Application\UseCases;

use Modules\Auth\Application\DTOs\RegisterUserDTO;
use Modules\Auth\Domain\UserRepositoryInterface;
use Modules\Auth\Domain\Exceptions\UserAlreadyExistsException;
use Modules\Auth\Domain\User;
use Illuminate\Support\Str;

class RegisterUser
{
    public function __construct(private UserRepositoryInterface $users) {}

    public function execute(RegisterUserDTO $dto)
    {
        $user = $this->users->findByEmail($dto->email);

        if ($user) {
            throw new UserAlreadyExistsException();
        }

        $user = new User(
            id: Str::uuid()->toString(),
            name: $dto->name,
            email: $dto->email,
            passwordHash: password_hash($dto->password, PASSWORD_BCRYPT),
            role: 'customer',
        );

        return $this->users->save($user);
    }
}
