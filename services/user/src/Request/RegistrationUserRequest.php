<?php

declare(strict_types=1);

namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class RegistrationUserRequest
{
    public function __construct(
        #[Assert\NotBlank(message: "Field fullname required")]
        #[Assert\Type('string')]
        public string $fullname,

        #[Assert\NotBlank(message: "Field login required")]
        #[Assert\Type('string')]
        public string $login,

        #[Assert\NotBlank(message: "Field login required")]
        #[Assert\Type('string')]
        public string $password,
    ) {

    }
}