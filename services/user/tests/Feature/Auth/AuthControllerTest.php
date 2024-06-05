<?php

declare(strict_types=1);

namespace App\Tests\Feature\Auth;

use App\Entity\User;
use App\Tests\DataFixtures\UserFixtures;
use Doctrine\ORM\EntityManagerInterface;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Spatie\Snapshots\MatchesSnapshots;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @coversDefaultClass \App\Controller\Auth\AuthController
 */
class AuthControllerTest extends WebTestCase
{
    use MatchesSnapshots;

    /**
     * @covers ::authenticate
     * @covers \App\Repository\UserRepository
     * @covers \App\Request\Auth\AuthenticateRequest
     * @covers \App\Service\Auth\AuthService
     * @covers \App\Types\Password
     */
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
