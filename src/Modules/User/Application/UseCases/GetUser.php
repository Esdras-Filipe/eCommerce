<?php

namespace Modules\User\Application\UseCases;

use Modules\User\Domain\UserRepositoryInterface;
use Modules\User\Domain\User;
use Modules\User\Domain\Exceptions\UserNotFoundException;
use Modules\User\Domain\Exceptions\UserPermissionDeniedException;
use Modules\User\Application\DTOs\UserDTO;

class GetUser
{
    public function __construct(private UserRepositoryInterface $users) {}

    public function execute(UserDTO $userDto, User $userLogged): User
    {
        if ($userLogged->id != $userDto->id && !$userLogged->isAdmin()) {
            throw new UserPermissionDeniedException();
        }

        $user = $this->users->findById($userDto->id);

        if (!$user) {
            throw new UserNotFoundException();
        }

        $userEntity = new User(id: $user->id, name: $user->name, email: $user->email, passwordHash: '', role: $user->role);
        return $userEntity;
    }
}
