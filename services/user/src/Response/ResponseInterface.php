<?php

declare(strict_types=1);

namespace App\Response;

interface ResponseInterface
{
    /**
     * @return array <mixed>
     */
    public function getData(): array;
}
