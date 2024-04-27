<?php

namespace App\Tests\Unit\Service\Hash;

use App\Service\Hash\HashService;
use App\Service\Hash\HashServiceInterface;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \App\Service\Hash\HashService
 */
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
    public function testHash(): void
    {
        $hashedPassword = $this->hashService->hash($this->secretPassword);

        $this->assertNotEquals($this->secretPassword, $hashedPassword);
        $this->assertTrue(password_verify($this->secretPassword, $hashedPassword));
    }

    /**
     * @covers ::verify
     */
    public function testVerify(): void
    {
        $hashedPassword = password_hash($this->secretPassword, PASSWORD_DEFAULT);
        $this->assertTrue($this->hashService->verify($this->secretPassword, $hashedPassword));
        $this->assertFalse($this->hashService->verify('wrongPassword', $hashedPassword));
    }
}