<?php

declare(strict_types=1);

namespace App\Tests\Feature\Auth;

use App\Controller\Auth\RegistrationController;
use PHPUnit\Framework\Attributes\CoversClass;
use Spatie\Snapshots\MatchesSnapshots;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

#[CoversClass(RegistrationController::class)]
class RegistrationControllerTest extends WebTestCase
{
    use MatchesSnapshots;

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
