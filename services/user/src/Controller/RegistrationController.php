<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\RegistrationUserDto;
use App\Exception\ValidationException;
use App\Request\RegistrationUserRequest;
use App\Response\RegistrationUserResponse;
use App\Service\AuthService;
use App\Types\Password;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

final class RegistrationController extends AbstractController
{
    /**
     * @throws ValidationException
     */
    #[Route(
        path: 'api/v1/user/registration',
        name: 'registration',
        methods: ['POST']
    )]
    public function __invoke(
        #[MapRequestPayload] RegistrationUserRequest $registrationUserRequest,
        AuthService                                  $authService
    ): JsonResponse
    {
        $registrationUserDto = new RegistrationUserDto(
            password: new Password($registrationUserRequest->password),
            login: $registrationUserRequest->login,
            fullName: $registrationUserRequest->fullname
        );

        $authService->registration($registrationUserDto);

        return $this->json((new RegistrationUserResponse(
            fullname: $registrationUserRequest->fullname,
            login: $registrationUserRequest->login
        ))->getData(), 201);
    }
}