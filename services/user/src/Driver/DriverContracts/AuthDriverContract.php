<?php

namespace App\Driver\DriverContracts;

use App\DTO\EncryptTokenDto;

interface AuthDriverContract
{
    /**
     * @param EncryptTokenDto $dto
     * @return string Access token
     */
    public function encryptAuthData(EncryptTokenDto $dto): string;
    public function verify(string $token): bool;
}