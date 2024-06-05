<?php

declare(strict_types=1);

namespace Balashov\Auth\Driver\DriverContracts;

use Balashov\Auth\DTO\EncryptTokenDto;

interface AuthDriverContract
{
    /**
     * @param EncryptTokenDto $dto
     * @return string Access token
     */
    public function encryptAuthData(EncryptTokenDto $dto): string;
    public function verify(string $token): bool;
}