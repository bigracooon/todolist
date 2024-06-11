<?php

declare(strict_types=1);

namespace Balashov\Auth\Service\Hash;

final readonly class HashService implements HashServiceInterface
{
    public function hash(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function verify(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
}
