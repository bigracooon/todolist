<?php

declare(strict_types=1);

namespace App\Response;

final readonly class RegistrationUserResponse implements ResponseInterface
{
    public function __construct(
        public string $fullname,
        public string $login,
    ) {
    }

    public function getData(): array
    {
        return [
            'login' => $this->fullname,
            'password' => $this->login
        ];
    }
}