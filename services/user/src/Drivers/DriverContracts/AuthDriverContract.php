<?php

namespace App\Drivers\DriverContracts;

use App\DTO\EncryptTokenDto;

interface AuthDriverContract
{
    public function encryptAuthData(EncryptTokenDto $dto): string;
    public function decryptAuthData();

    public function verify(string $token): bool;
}