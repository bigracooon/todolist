<?php

namespace App\Tests\Unit\Types;

use App\Exception\ValidationException;
use App\Types\Password;
use Faker\Factory;
use Faker\Generator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Password::class)]
class PasswordTest extends TestCase
{
    private Generator $faker;

    protected function setUp(): void
    {
        $this->faker = Factory::create();
        parent::setUp();
    }

    /**
     * @throws ValidationException
     */
    public function testValidPassword(): void
    {
        $stringPassword = $this->faker->password(8, 16);
        $password = new Password($stringPassword);
        $this->assertEquals($stringPassword, $password->value);
    }

    /**
     * @throws ValidationException
     */
    public function testLessThanEightCharacters(): void
    {
        $stringPassword = $this->faker->password(1, 7);
        $this->expectException(ValidationException::class);
        $password = new Password($stringPassword);
    }
}
