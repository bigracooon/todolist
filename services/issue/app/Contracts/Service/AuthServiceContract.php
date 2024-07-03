<?php

namespace App\Contracts\Service;

interface AuthServiceContract
{
    public function verifyToken(string $token): bool;
}
