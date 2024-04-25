<?php

namespace App\Service\Auth;

use App\DTO\AuthenticationDto;
use App\DTO\RegistrationUserDto;

interface AuthServiceInterface
{
    public function registration(RegistrationUserDto $dto): void;
    public function authenticate(AuthenticationDto $dto): string;
}