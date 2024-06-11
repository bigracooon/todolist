<?php

declare(strict_types=1);

namespace App\DTO;

use App\Types\Password;

final readonly class RegistrationUserDto
{
    public function __construct(
        public Password $password,
        public string $login,
        public string $fullName
    ) {
    }
}
