<?php

declare(strict_types=1);

namespace Balashov\Auth\Driver\V1\Auth;

use Balashov\Auth\Driver\DriverContracts\AuthDriverContract;
use Balashov\Auth\DTO\EncryptTokenDto;

final readonly class JwtDriver implements AuthDriverContract
{
    public function __construct(
        public string $authSecretKey
    ) {
    }

    public function encryptAuthData(EncryptTokenDto $dto): string
    {
        $header = $this->base64url_encode((string)json_encode([
            'alg' => 'HS256',
            'typ' => 'JWT',
            'exp' => time() + 3600,
        ]));

        $payload = $this->base64url_encode((string)json_encode([
            'userId' => $dto->userId,
            'login' => $dto->login,
        ]));

        $unsignedToken = $header . "." . $payload;
        $signature = hash_hmac('sha256', $unsignedToken, $this->authSecretKey);
        return $header . "." . $payload . "." . base64_encode($signature);
    }

    public function verify(string $token): bool
    {
        return false;
    }

    private function base64url_encode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
}