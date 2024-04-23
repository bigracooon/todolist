<?php

declare(strict_types=1);

namespace App\Drivers\V1\Auth;

use App\Drivers\DriverContracts\AuthDriverContract;
use App\DTO\EncryptTokenDto;

final readonly class JwtDriver implements AuthDriverContract
{
    public function __construct(
        public string $authSecretKey
    ) {
    }

    public function encryptAuthData(EncryptTokenDto $dto): string
    {
        $header = $this->base64url_encode(json_encode([
            'alg' => 'HS256',
            'typ' => 'JWT',
            'exp' => time() + 3600,
        ]));

        $payload = $this->base64url_encode(json_encode([
            'userId' => $dto->userId,
            'login' => $dto->login,
        ]));

        $unsignedToken = $header . "." . $payload;
        $signature = hash_hmac('sha256', $unsignedToken, $this->authSecretKey);
        return $header . "." . $payload . "." . base64_encode($signature);
    }

    public function decryptAuthData()
    {
        // TODO: Implement decryptAuthData() method.
    }

    public function verify(string $token): bool
    {
        return false;
    }

    private function base64url_encode($data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
}