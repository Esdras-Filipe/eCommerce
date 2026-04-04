<?php

namespace Modules\Auth\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Modules\Auth\Domain\User;
use Modules\Auth\Tests\Fakes\FakeTokenGenerator;
use Modules\Auth\Tests\Fakes\FakeUserRepository;
use Modules\Auth\Application\UseCases\LoginUser;
use Modules\Auth\Domain\Exceptions\UserNotFoundException;
use Modules\Auth\Domain\Exceptions\InvalidCredentialsException;

class LoginUserTest extends TestCase
{
    public function test_returns_token_when_credentials_are_valid(): void
    {
        $fakeUser = new User(
            id: '123',
            name: 'Teste',
            email: 'joao@email.com',
            passwordHash: password_hash('senha123', PASSWORD_BCRYPT),
            role: 'admin'
        );

        $fakeRepo = new FakeUserRepository();
        $fakeRepo->add($fakeUser);

        $fakeTokenGenerator = new FakeTokenGenerator();

        $useCase = new LoginUser($fakeRepo, $fakeTokenGenerator);

        $token = $useCase->execute(email: 'joao@email.com', password: 'senha123');

        $this->assertNotEmpty($token);
    }

    public function test_throws_exception_when_user_not_found(): void
    {
        $fakeRepo = new FakeUserRepository();
        $useCase = new LoginUser($fakeRepo, new FakeTokenGenerator());

        $this->expectException(UserNotFoundException::class);

        $useCase->execute(email: 'naoexiste@email.com', password: '123');
    }

    public function test_throws_exception_when_password_is_wrong(): void
    {
        $fakeUser = new User(
            id: '123',
            email: 'joao@email.com',
            name: 'Teste',
            passwordHash: password_hash('senha123', PASSWORD_BCRYPT),
            role: 'admin'
        );

        $fakeRepo = new FakeUserRepository();
        $fakeRepo->add($fakeUser);

        $useCase = new LoginUser($fakeRepo, new FakeTokenGenerator());

        $this->expectException(InvalidCredentialsException::class);

        $useCase->execute(email: 'joao@email.com', password: 'senhaerrada');
    }
}
