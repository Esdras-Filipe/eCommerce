<?php

namespace Modules\User\Application\UseCases;

use Modules\User\Application\DTOs\ListUsersDTO;
use Modules\User\Application\DTOs\UserCollectionDTO;
use Modules\User\Domain\UserRepositoryInterface;
use Modules\User\Domain\Exceptions\UserPermissionDeniedException;
use Modules\User\Domain\User;

class ListUsers
{
    public function __construct(private UserRepositoryInterface $users) {}

    public function execute(ListUsersDTO $dto, User $userLogged): UserCollectionDTO
    {
        if (!$userLogged->isAdmin()) {
            throw new UserPermissionDeniedException();
        }

        $users = $this->users->search($dto);

        return new UserCollectionDTO(
            items: $users->items(),
            total: $users->total(),
            perPage: $users->perPage(),
            currentPage: $users->currentPage()
        );
    }
}
