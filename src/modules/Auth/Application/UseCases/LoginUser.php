<?php

namespace Modules\Auth\Application\UseCases;

// Injeção de dependência
use Modules\Auth\Domain\UserRepositoryInterface;
use Modules\Auth\Domain\TokenGeneratorInterface;

//Exceções
use Modules\Auth\Domain\Exceptions\InvalidCredentialsException;
use Modules\Auth\Domain\Exceptions\UserNotFoundException;

class LoginUser
{
    public function __construct(
        private UserRepositoryInterface $users,
        private TokenGeneratorInterface $tokenGenerator,
    ) {}

    public function execute(string $email, string $password): string
    {
        $user = $this->users->findByEmail($email);

        if (!$user) {
            throw new UserNotFoundException();
        }

        if (!password_verify($password, $user->passwordHash)) {
            throw new InvalidCredentialsException();
        }

        return $this->tokenGenerator->generate($user);
    }
}
