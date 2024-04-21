<?php

namespace App\Service;

use App\DTO\AuthenticationDto;
use App\DTO\RegistrationUserDto;
use App\Entity\User;
use App\Exception\ValidationException;
use App\Repository\UserRepository;
use App\Service\Hash\HashServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

final readonly class AuthService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserRepository         $userRepository,
        private HashServiceInterface   $hashService,
    )
    {
    }

    /**
     * @throws ValidationException
     */
    public function registration(RegistrationUserDto $dto): void
    {
        $existedUser = $this->userRepository->findOneBy(['login' => $dto->login]);

        if ($existedUser) {
            throw new ValidationException(
                message: "User {$dto->login} already exists"
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
     * @throws ValidationException
     */
    public function authenticate(AuthenticationDto $dto): void
    {
        $existedUser = $this->userRepository->findOneBy(['login' => $dto->login]);

        if (!$existedUser) {
            throw new ValidationException(
                message: "User with {$dto->login} undefined"
            );
        }

        $verified = $this->hashService->verify($dto->password->value, $existedUser->password);

        if (!$verified) {
            throw new ValidationException(
                message: "User with {$dto->login} not verified"
            );
        }
    }
}