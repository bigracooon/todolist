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
        $testSecret = '8f6eb96b-4f03-4d14-aa34-e538600151fd';
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
    public function verify(): void
    {
        $testSecret = 'bb24e484-494a-4225-9d6f-0cd524e3194c';

        $jwtDriver = new JwtDriver($testSecret);

        $encryptTokenDto = new EncryptTokenDto(
            userId: Uuid::uuid4()->toString(),
            login: "Test"
        );

        $hash = $jwtDriver->encryptAuthData($encryptTokenDto);

        $this->assertTrue($jwtDriver->verify($hash));
    }

    #[Test]
    public function notVerified(): void
    {
        $testSecret = '33222577-2253-4c56-b725-46042e825978';
        $invalidHash = '27af0756-6102-4b11-8ccd-466f3cabb5cf';
        $jwtDriver = new JwtDriver($testSecret);
        $this->assertFalse($jwtDriver->verify($invalidHash));
    }
}
