<?php

namespace Modules\Auth\Application\UseCases;

use Modules\Auth\Application\DTOs\UpdateUserDTO;
use Modules\Auth\Domain\UserRepositoryInterface;
use Modules\Auth\Domain\Exceptions\UserNotFoundException;
use Modules\Auth\Domain\User;

class UpdateUser
{
    public function __construct(private UserRepositoryInterface $users) {}

    public function execute(UpdateUserDTO $dto)
    {
        $currentUser = $this->users->findById($dto->id);

        if (!$currentUser) {
            throw new UserNotFoundException();
        }

        $user = new User(
            id: $dto->id,
            name: $dto->name ?? $currentUser->name,
            email: $dto->email ?? $currentUser->email,
            passwordHash: $currentUser->passwordHash,
            role: $dto->role ?? $currentUser->role,
            email_verified_at: $dto->email_verified_at ?? $currentUser->email_verified_at,
            remember_token: $dto->remember_token ?? $currentUser->remember_token,
        );

        return $this->users->update($user);
    }
}
