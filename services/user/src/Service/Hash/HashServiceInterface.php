<?php

namespace App\Service\Hash;

interface HashServiceInterface
{
    public function hash(string $password): string;
    public function verify(string $password, string $hash): bool;
}