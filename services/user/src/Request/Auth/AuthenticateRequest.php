<?php

namespace App\Request\Auth;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class AuthenticateRequest
{
    public function __construct(
        #[Assert\NotBlank(message: "Field login required")]
        #[Assert\Type('string')]
        public string $login,

        #[Assert\NotBlank(message: "Field password required")]
        #[Assert\Type('string')]
        public string $password,
    ) {
    }
}