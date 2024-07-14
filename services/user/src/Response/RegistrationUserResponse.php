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

    /**
     * @return array{
     *     'fullname': string,
     *     'login': string
     * }
     */
    public function getData(): array
    {
        return [
            'fullname' => $this->fullname,
            'login' => $this->login
        ];
    }
}
