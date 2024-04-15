<?php

namespace App\Service;

use App\DTO\RegistrationUserDto;
use App\Entity\User;
use App\Exception\ValidationException;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AuthService
{
    public function __construct(
        private readonly UserPasswordHasherInterface $hasher,
        private readonly EntityManagerInterface      $entityManager,
        private UserRepository                       $userRepository
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
        );

        $password = $this->hasher->hashPassword($user, $dto->password->password);
        $user->setPassword($password);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}