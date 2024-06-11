<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\Auth;

use App\DTO\AuthenticationDto;
use App\DTO\RegistrationUserDto;
use App\Entity\User;
use App\Exception\ValidationException;
use App\Repository\UserRepository;
use App\Service\Auth\AuthService;
use App\Types\Password;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Balashov\Auth\Driver\DriverContracts\AuthDriverContract;
use Balashov\Auth\Service\Hash\HashServiceInterface;

/**
 * @coversDefaultClass \App\Service\Auth\AuthService
 */
class AuthServiceTest extends TestCase
{
    private MockObject $entityManagerInterfaceMock;
    private MockObject $userRepositoryMock;
    private MockObject $hashServiceMock;
    private MockObject $authDriverMock;
    private AuthService $authService;

    protected function setUp(): void
    {
        $this->entityManagerInterfaceMock = $this->createMock(EntityManagerInterface::class);
        $this->userRepositoryMock = $this->createMock(UserRepository::class);
        $this->hashServiceMock = $this->createMock(HashServiceInterface::class);
        $this->authDriverMock = $this->createMock(AuthDriverContract::class);

        $this->authService = new AuthService(
            $this->entityManagerInterfaceMock,
            $this->userRepositoryMock,
            $this->hashServiceMock,
            $this->authDriverMock
        );

        parent::setUp();
    }

    /**
     * @covers ::registration
     * @covers ::__construct
     * @covers \App\Types\Password
     * @covers \App\DTO\RegistrationUserDto
     * @covers \App\Entity\User
     * @throws ValidationException
     */
    public function testRegistration(): void
    {
        $registrationUserDto = new RegistrationUserDto(
            password: new Password('password'),
            login: 'login',
            fullName: 'Ivanov Ivan'
        );

        $this->userRepositoryMock
            ->expects($this->once())
            ->method('findOneBy')
            ->willReturn(null);

        $this->hashServiceMock
            ->expects($this->once())
            ->method('hash')
            ->willReturn("hashed_password");

        $this->entityManagerInterfaceMock
            ->expects($this->once())
            ->method('persist');

        $this->entityManagerInterfaceMock
            ->expects($this->once())
            ->method('flush');

        $this->authService->registration($registrationUserDto);
    }

    /**
     * @covers \App\Entity\User
     * @covers \App\DTO\RegistrationUserDto
     * @covers \App\Types\Password
     * @covers ::registration
     * @covers ::__construct
     * @throws ValidationException
     */
    public function testUserAlreadyExists(): void
    {
        $registrationUserDto = new RegistrationUserDto(
            password: new Password('password'),
            login: 'login',
            fullName: 'Ivanov Ivan'
        );

        $user = new User(
            $registrationUserDto->fullName,
            $registrationUserDto->login,
            $registrationUserDto->password->value
        );

        $this->userRepositoryMock->method('findOneBy')->willReturn($user);
        $this->expectException(ValidationException::class);
        $this->authService->registration($registrationUserDto);
    }

    /**
     * @covers ::authenticate
     * @covers ::__construct
     * @covers \App\Types\Password
     * @covers \App\Entity\User
     * @covers \App\DTO\AuthenticationDto
     * @throws ValidationException
     */
    public function testAuthenticate(): void
    {
        $password = 'password';

        $authenticationDto = new AuthenticationDto(
            login: 'login',
            password: new Password($password)
        );

        $user = new User(
            fullname: 'Ivanov Ivan',
            login: 'login',
            password: $password
        );

        $this->userRepositoryMock
            ->expects($this->once())
            ->method('findOneBy')
            ->willReturn($user);

        $this->hashServiceMock
            ->expects($this->once())
            ->method('verify')
            ->willReturn(true);

        $this->authDriverMock
            ->expects($this->once())
            ->method('encryptAuthData')
            ->willReturn('encrypted_token');

        $result = $this->authService->authenticate($authenticationDto);

        $this->assertEquals('encrypted_token', $result);
    }

    /**
     * @covers ::authenticate
     * @covers ::__construct
     * @covers \App\Types\Password
     * @covers \App\DTO\AuthenticationDto
     * @throws ValidationException
     */
    public function testUserUndefined(): void
    {
        $authenticationDto = new AuthenticationDto(
            login: 'login',
            password: new Password('password')
        );

        $this->userRepositoryMock
            ->expects($this->once())
            ->method('findOneBy')
            ->willReturn(null);

        $this->expectException(ValidationException::class);
        $this->authService->authenticate($authenticationDto);
    }

    /**
     * @covers ::authenticate
     * @covers ::__construct
     * @covers \App\DTO\AuthenticationDto
     * @covers \App\Entity\User
     * @covers \App\Service\Auth\AuthService
     * @covers \App\Types\Password
     * @throws ValidationException
     */
    public function testUnverifiedUser(): void
    {
        $password = 'password';
        $invalidPassword = 'invalid_password';

        $authenticationDto = new AuthenticationDto(
            login: 'login',
            password: new Password($invalidPassword)
        );

        $user = new User(
            fullname: 'Ivanov Ivan',
            login: 'login',
            password: $password
        );

        $this->userRepositoryMock
            ->expects($this->once())
            ->method('findOneBy')
            ->willReturn($user);

        $this->hashServiceMock
            ->expects($this->once())
            ->method('verify')
            ->willReturn(false);

        $this->expectException(ValidationException::class);
        $this->authService->authenticate($authenticationDto);
    }
}
