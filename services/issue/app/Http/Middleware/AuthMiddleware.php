<?php

namespace App\Http\Middleware;

use App\Contracts\Service\AuthServiceContract;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final readonly class AuthMiddleware
{
    public function __construct(
        private AuthServiceContract $authService
    ) {
    }

    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->get('token');
        if (!empty($token) && $this->authService->verifyToken($token)) {
            return $next($request);
        }

        return response('Forbidden', Response::HTTP_FORBIDDEN);
    }
}
