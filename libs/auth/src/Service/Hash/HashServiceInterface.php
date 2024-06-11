<?php

declare(strict_types=1);

namespace Balashov\Auth\Service\Hash;

interface HashServiceInterface
{
    public function hash(string $password): string;
    public function verify(string $password, string $hash): bool;
}
