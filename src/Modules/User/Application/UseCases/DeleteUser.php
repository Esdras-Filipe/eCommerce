<?php

namespace Modules\User\Application\UseCases;

use Modules\User\Domain\UserRepositoryInterface;
use Modules\User\Domain\User;
use Modules\User\Application\DTOs\DeleteUserDTO;
use Modules\User\Domain\Exceptions\UserNotFoundException;
use Modules\User\Domain\Exceptions\UserPermissionDeniedException;

class DeleteUser
{
    public function __construct(private UserRepositoryInterface $users) {}

    public function execute(DeleteUserDTO $dto, User $userLogged): bool
    {
        if ($userLogged != $dto->id && !$userLogged->isAdmin()) {
            throw new UserPermissionDeniedException();
        }

        $user = $this->users->findById($dto->id);
        if (!$user) {
            throw new UserNotFoundException();
        }

        $user = new User(id: $dto->id, name: '', email: '', passwordHash: '', role: '');
        return $this->users->delete($user);
    }
}
