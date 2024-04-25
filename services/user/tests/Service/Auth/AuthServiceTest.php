<?php

declare(strict_types=1);

namespace App\Tests\Service\Auth;

use App\Drivers\DriverContracts\AuthDriverContract;
use App\DTO\AuthenticationDto;
use App\DTO\RegistrationUserDto;
use App\Entity\User;
use App\Exception\ValidationException;
use App\Repository\UserRepository;
use App\Service\Auth\AuthService;
use App\Service\Hash\HashServiceInterface;
use App\Types\Password;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \App\Service\Auth\AuthService
 */
class AuthServiceTest extends TestCase
{
    private EntityManagerInterface $entityManagerInterfaceMock;
    private UserRepository $userRepositoryMock;
    private HashServiceInterface $hashServiceMock;
    private AuthDriverContract $authDriverMock;
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
    public function testRegistration()
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
     * @covers ::authenticate
     * @covers ::__construct
     * @covers \App\Types\Password
     * @covers \App\Entity\User
     * @covers \App\DTO\AuthenticationDto
     * @covers \App\DTO\EncryptTokenDto
     * @throws ValidationException
     */
    public function testAuthenticate()
    {
        $authenticationDto = new AuthenticationDto(
            login: 'login',
            password: new Password('password')
        );

        $user = new User(
            fullname: 'Ivanov Ivan',
            login: 'login',
            password: 'hashed_password'
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
}