<?php

declare(strict_types=1);

namespace App\DTO\Response;

interface ResponseInterface
{
    public function getData(): array;
}