<?php

declare(strict_types=1);

namespace App\DTO;

use Symfony\Component\Uid\Uuid;

final readonly class EncryptTokenDto
{
    public function __construct(
        public Uuid  $userId,
        public string $login,
    ) {
    }
}