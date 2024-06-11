<?php

namespace App\Types;

use App\Exception\ValidationException;

final readonly class Password
{
    /**
     * @throws ValidationException
     */
    public function __construct(
        public string $value
    ) {
        if (strlen($this->value) < 8) {
            throw new ValidationException(
                'Password must be more than 8 characters',
                422
            );
        }
    }
}
