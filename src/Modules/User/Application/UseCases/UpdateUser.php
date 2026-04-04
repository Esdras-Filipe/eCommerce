<?php

namespace Modules\User\Application\UseCases;

use Modules\User\Application\DTOs\UpdateUserDTO;
use Modules\User\Domain\UserRepositoryInterface;
use Modules\User\Domain\Exceptions\UserNotFoundException;
use Modules\User\Domain\Exceptions\UserPermissionDeniedException;
use Modules\User\Domain\User;

class UpdateUser
{
    public function __construct(private UserRepositoryInterface $users) {}

    public function execute(UpdateUserDTO $dto, User $userLogged): User
    {
        if ($userLogged->id != $dto->id && !$userLogged->isAdmin()) {
            throw new UserPermissionDeniedException();
        }

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

        $this->users->update($user);
        return $user;
    }
}
