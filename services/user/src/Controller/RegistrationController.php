<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\Request\RegistrationUserRequest;
use App\DTO\Response\RegistrationUserResponse;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

final class RegistrationController extends AbstractController
{
    #[Route(
        path: 'api/v1/user/registration',
        name: 'registration',
        methods: ['POST']
    )]
    public function __invoke(
        #[MapRequestPayload] RegistrationUserRequest $registrationUserRequest,
        EntityManagerInterface                       $entityManager,
        UserPasswordHasherInterface                  $hasher,
    ): JsonResponse
    {
        $user = new User(
            fullname: $registrationUserRequest->fullname,
            login: $registrationUserRequest->login,
        );

        $password = $hasher->hashPassword($user, $registrationUserRequest->password);
        $user->setPassword($password);
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->json((new RegistrationUserResponse(
            fullname: $registrationUserRequest->fullname,
            login: $registrationUserRequest->login
        ))->getData(), 201);
    }
}