<?php

namespace App\Controller\Me;

use App\Controller\BaseAbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class MeController extends BaseAbstractController
{
    #[Route(
        path: 'api/v1/user/me',
        name: 'me',
        methods: ['GET']
    )]
    public function me(): JsonResponse
    {
        return $this->json([]);
    }
}