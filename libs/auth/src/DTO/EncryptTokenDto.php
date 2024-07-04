<?php

declare(strict_types=1);

namespace Balashov\Auth\DTO;

/**
 * Class EncryptTokenDto
 */
final readonly class EncryptTokenDto
{
    /**
     * @param string $userId
     * @param string $login
     */
    public function __construct(
        public string $userId,
        public string $login,
    ) {
    }
}
