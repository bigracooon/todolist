<?php

declare(strict_types=1);

namespace App\Tests\Feature\Auth;

use App\Controller\Auth\RegistrationController;
use App\Repository\UserRepository;
use App\Request\Auth\RegistrationUserRequest;
use App\Response\RegistrationUserResponse;
use App\Service\Auth\AuthService;
use App\Tests\Feature\BaseWebTestCase;
use App\Types\Password;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use Spatie\Snapshots\MatchesSnapshots;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

#[
    CoversClass(RegistrationController::class),
    UsesClass(UserRepository::class),
    UsesClass(RegistrationUserRequest::class),
    UsesClass(AuthService::class),
    UsesClass(Password::class),
    UsesClass(RegistrationUserResponse::class),
]
class RegistrationControllerTest extends BaseWebTestCase
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
