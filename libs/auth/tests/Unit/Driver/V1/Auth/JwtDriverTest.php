<?php

namespace Driver\V1\Auth;

use Balashov\Auth\Driver\V1\Auth\JwtDriver;
use Balashov\Auth\DTO\EncryptTokenDto;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

#[
    CoversClass(JwtDriver::class),
    UsesClass(EncryptTokenDto::class)
]
class JwtDriverTest extends TestCase
{
    #[Test]
    public function encryptAuthDataReturnsValidJwt(): void
    {
        $testSecret = 'testSecret';
        $encryptTokenDto = new EncryptTokenDto(
            userId: Uuid::uuid4()->toString(),
            login: "Test"
        );
        $jwtDriver = new JwtDriver($testSecret);
        $hash = $jwtDriver->encryptAuthData($encryptTokenDto);
        $parts = explode(".", $hash);

        $this->assertCount(3, $parts);
        $this->assertMatchesRegularExpression('/^[a-zA-Z0-9-_+=\/]*$/', $parts[0]);
        $this->assertMatchesRegularExpression('/^[a-zA-Z0-9-_+=\/]*$/', $parts[1]);
        $this->assertMatchesRegularExpression('/^[a-zA-Z0-9-_+=\/]*$/', $parts[2]);
    }

    #[Test]
    public function verifyMethod(): void
    {
        $jwtDriver = new JwtDriver('testSecret');
        $jwtToken = 'test.jwt.token';
        $this->assertFalse($jwtDriver->verify($jwtToken));
    }
}
