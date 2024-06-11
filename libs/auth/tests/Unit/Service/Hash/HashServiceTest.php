<?php

declare(strict_types=1);

namespace Balashov\Unit\Service;

use Balashov\Auth\DTO\EncryptTokenDto;
use Balashov\Auth\Service\Hash\HashService;
use Balashov\Auth\Service\Hash\HashServiceInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[
    CoversClass(HashService::class),
    UsesClass(EncryptTokenDto::class)
]
class HashServiceTest extends TestCase
{
    private HashServiceInterface $hashService;
    private string $secretPassword;

    protected function setUp(): void
    {
        parent::setUp();
        $this->hashService = new HashService();
        $this->secretPassword = 'secretPassword';
    }

    /**
     * @covers ::hash
     */
    #[Test]
    public function hash(): void
    {
        $hashedPassword = $this->hashService->hash($this->secretPassword);

        $this->assertNotEquals($this->secretPassword, $hashedPassword);
        $this->assertTrue(password_verify($this->secretPassword, $hashedPassword));
    }

    /**
     * @covers ::verify
     */
    #[Test]
    public function verify(): void
    {
        $hashedPassword = password_hash($this->secretPassword, PASSWORD_DEFAULT);
        $this->assertTrue($this->hashService->verify($this->secretPassword, $hashedPassword));
        $this->assertFalse($this->hashService->verify('wrongPassword', $hashedPassword));
    }
}
