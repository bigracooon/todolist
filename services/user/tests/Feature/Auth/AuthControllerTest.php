<?php

declare(strict_types=1);

namespace App\Tests\Feature\Auth;

use App\Controller\Auth\AuthController;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Request\Auth\AuthenticateRequest;
use App\Service\Auth\AuthService;
use App\Tests\DataFixtures\UserFixtures;
use App\Tests\Feature\BaseWebTestCase;
use App\Types\Password;
use Doctrine\ORM\EntityManagerInterface;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use Spatie\Snapshots\MatchesSnapshots;

#[
    CoversClass(AuthController::class),
    UsesClass(UserRepository::class),
    UsesClass(AuthenticateRequest::class),
    UsesClass(AuthService::class),
    UsesClass(Password::class)
]
class AuthControllerTest extends BaseWebTestCase
{
    use MatchesSnapshots;

    public function testAuth(): void
    {
        $client = self::createClient();

        /** @var DatabaseToolCollection $tool */
        $tool = $this->getContainer()->get(DatabaseToolCollection::class);
        $tool->get()->loadFixtures([UserFixtures::class]);

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $this->getContainer()->get(EntityManagerInterface::class);
        $userRepository = $entityManager->getRepository(User::class);

        /** @var User $user */
        $user = $userRepository
            ->createQueryBuilder('u')
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleResult();

        $client->request('POST', '/api/v1/user/auth', [
            'login' => $user->login,
            'password' => '12345678'
        ]);

        $this->assertResponseIsSuccessful();
    }
}
