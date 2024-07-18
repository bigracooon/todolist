<?php

namespace App\EventListener\Http;

use App\Service\Auth\AuthServiceInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

final readonly class TokenListener
{
    public function __construct(
        private AuthServiceInterface $authService
    ) {
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        $route = $request->attributes->get('_route');

        // TODO Перенести в файл конфигурации
        $routesWithToken = [
            'me'
        ];

        if (in_array($route, $routesWithToken)) {
            $token = $request->query->has('token') ? $request->query->get('token') : null;

            if (!$this->isValidToken($token)) {
                throw new AccessDeniedHttpException('Invalid token');
            }
        }
    }

    private function isValidToken($token): bool
    {
        return $this->authService->verify($token);
    }
}