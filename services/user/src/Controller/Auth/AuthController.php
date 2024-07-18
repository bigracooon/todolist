<?php

declare(strict_types=1);

namespace App\Controller\Auth;

use App\Controller\BaseAbstractController;
use App\DTO\AuthenticationDto;
use App\Exception\ValidationException;
use App\Request\Auth\AuthenticateRequest;
use App\Service\Auth\AuthService;
use App\Types\Password;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

final class AuthController extends BaseAbstractController
{
    /**
     * @throws ValidationException
     */
    #[Route(
        path: 'api/v1/user/auth',
        name: 'authentication',
        methods: ['POST']
    )]
    public function authenticate(
        #[MapRequestPayload] AuthenticateRequest $authenticateRequest,
        AuthService                              $authService
    ): JsonResponse {
        $dto = new AuthenticationDto(
            login: $authenticateRequest->login,
            password: new Password($authenticateRequest->password),
        );

        $token = $authService->authenticate($dto);

        return $this->json([
            'login' => $dto->login,
            'access_token' => $token,
        ]);
    }
}
