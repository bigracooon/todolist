<?php

namespace App\Service;

use App\Contracts\Service\AuthServiceContract;
use Balashov\Auth\Driver\V1\Auth\JwtDriver;

final readonly class AuthService implements AuthServiceContract
{
    public function __construct()
    {
    }

    public function verifyToken(string $token): bool
    {
        $jwtDriver = new JwtDriver(config('auth.secret_key'));
        return $jwtDriver->verify($token);
    }
}
