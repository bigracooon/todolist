<?php

declare(strict_types=1);

namespace App\Service\Auth;

use App\DTO\AuthenticationDto;
use App\DTO\RegistrationUserDto;
use App\Entity\User;
use App\Exception\ValidationException;
use App\Repository\UserRepository;
use Balashov\Auth\Driver\DriverContracts\AuthDriverContract;
use Balashov\Auth\DTO\EncryptTokenDto;
use Balashov\Auth\Service\Hash\HashServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

final readonly class AuthService implements AuthServiceInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserRepository         $userRepository,
        private HashServiceInterface   $hashService,
        private AuthDriverContract     $authDriver,
    ) {
    }

    /**
     * @throws ValidationException
     */
    public function registration(RegistrationUserDto $dto): void
    {
        $existedUser = $this->userRepository->findOneBy(['login' => $dto->login]);

        if ($existedUser) {
            throw new ValidationException(
                message: "User $dto->login already exists"
            );
        }

        $user = new User(
            fullname: $dto->fullName,
            login: $dto->login,
            password: ($this->hashService->hash($dto->password->value)),
        );

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }


    /**
     * @param AuthenticationDto $dto
     * @return string Access token
     * @throws ValidationException
     */
    public function authenticate(AuthenticationDto $dto): string
    {
        $user = $this->userRepository->findOneBy(['login' => $dto->login]);

        if (!$user) {
            throw new ValidationException(
                message: "User with $dto->login undefined"
            );
        }

        $verified = $this->hashService->verify($dto->password->value, $user->password);

        if (!$verified) {
            throw new ValidationException(
                message: "User with $dto->login not verified"
            );
        }

        $payloadTokenDto = new EncryptTokenDto(
            $user->id->toRfc4122(),
            $user->login
        );

        return $this->authDriver->encryptAuthData($payloadTokenDto);
    }
}
