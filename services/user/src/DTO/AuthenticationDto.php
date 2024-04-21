<?php

namespace App\DTO;

use App\Types\Password;

final readonly class AuthenticationDto
{
    public function __construct(
        public readonly string $login,
        public readonly Password $password
    ) {
    }
}