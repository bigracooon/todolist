<?php

declare(strict_types=1);

namespace App\Service;

use App\Contracts\Service\AuthServiceContract;
use Balashov\Auth\Driver\V1\Auth\JwtDriver;

final readonly class AuthService implements AuthServiceContract
{
    public function verifyToken(string $token): bool
    {
        $jwtDriver = new JwtDriver(config('auth.secret_key'));
        return $jwtDriver->verify($token);
    }
}
