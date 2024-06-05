<?php

declare(strict_types=1);

namespace App\Tests\Feature\Auth;

use Spatie\Snapshots\MatchesSnapshots;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @coversDefaultClass \App\Controller\Auth\RegistrationController
 */
class RegistrationControllerTest extends WebTestCase
{
    use MatchesSnapshots;

    /**
     * @covers ::__invoke
     * @covers \Driver\V1\Auth\JwtDriver
     * @covers \App\Repository\UserRepository
     * @covers \App\Request\Auth\RegistrationUserRequest
     * @covers \App\Response\RegistrationUserResponse
     * @covers \App\Types\Password
     * @covers \Hash\HashService
     * @covers \App\Service\Auth\AuthService
     */
    public function testRegistration(): void
    {
        $client = static::createClient();

        $payload = [
            "password" => "testPassword",
            "login" => "testLogin",
            "fullname" => "Test Full Name",
        ];

        $client->request('POST', '/api/v1/user/registration', $payload);
        $this->assertMatchesJsonSnapshot($client->getResponse()->getContent());
    }
}
