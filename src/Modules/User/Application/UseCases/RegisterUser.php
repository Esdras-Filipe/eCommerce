<?php

namespace Modules\User\Application\UseCases;

use Modules\User\Application\DTOs\RegisterUserDTO;
use Modules\User\Domain\UserRepositoryInterface;
use Modules\User\Domain\Exceptions\UserAlreadyExistsException;
use Modules\User\Domain\Exceptions\UserPermissionDeniedException;
use Modules\User\Domain\User;
use Illuminate\Support\Str;

class RegisterUser
{
    public function __construct(private UserRepositoryInterface $users) {}

    public function execute(RegisterUserDTO $dto, User $userLogged): User
    {
        if (!$userLogged->isAdmin()) {
            throw new UserPermissionDeniedException();
        }

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
