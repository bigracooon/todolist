<?php

declare(strict_types=1);

namespace Tests\Unit\Service;

use App\Contracts\Service\AuthServiceContract;
use App\Service\AuthService;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class AuthServiceTest extends TestCase
{
    private AuthServiceContract $authService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->authService = new AuthService();
    }

    #[Test]
    public function failedVerifyToken(): void
    {
        $token = 'test.test.test';
        $this->assertFalse($this->authService->verifyToken($token));
    }
}
