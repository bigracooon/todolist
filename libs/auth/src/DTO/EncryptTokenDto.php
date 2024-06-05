<?php

declare(strict_types=1);

namespace Balashov\Auth\DTO;

final readonly class EncryptTokenDto
{
    public function __construct(
        public string $userId,
        public string $login,
    ) {
    }
}