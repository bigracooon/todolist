<?php

namespace Driver\V1\Auth;

use Balashov\Auth\Driver\V1\Auth\JwtDriver;
use Balashov\Auth\DTO\EncryptTokenDto;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * @coversDefaultClass \Balashov\Auth\Driver\V1\Auth\JwtDriver
 */
class JwtDriverTest extends TestCase
{
    /**
     * @return void
     * @covers ::encryptAuthData
     * @covers ::__construct
     * @covers \Balashov\Auth\DTO\EncryptTokenDto
     * @covers ::base64url_encode
     */
    public function testEncryptAuthDataReturnsValidJwt(): void
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

    /**
     * @return void
     * @covers ::verify
     * @covers ::__construct
     */
    public function testVerifyMethod(): void
    {
        $jwtDriver = new JwtDriver('testSecret');
        $jwtToken = 'test.jwt.token';
        $this->assertFalse($jwtDriver->verify($jwtToken));
    }
}
