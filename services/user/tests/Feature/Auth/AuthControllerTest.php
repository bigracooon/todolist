<?php

declare(strict_types=1);

namespace App\Tests\Feature\Auth;

use App\Entity\User;
use App\Tests\DataFixtures\UserFixtures;
use Spatie\Snapshots\MatchesSnapshots;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Doctrine\ORM\EntityManagerInterface;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @coversDefaultClass \App\Controller\Auth\AuthController
 */
class AuthControllerTest extends WebTestCase
{
    use MatchesSnapshots;

    protected AbstractDatabaseTool $databaseTool;
    protected EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        parent::setUp();
        $this->databaseTool = self::getContainer()->get(DatabaseToolCollection::class);
        $this->entityManager = self::getContainer()->get(EntityManagerInterface::class);
    }

    /**
     * @covers ::authenticate
     */
    public function testAuth(): void
    {
        $this->databaseTool->get()->loadFixtures([
            UserFixtures::class
        ]);

        $user = $this->entityManager->getRepository(User::class)->findAll();

        dd($user);
        $client = static::createClient();

        $client->request('POST', '/api/v1/user/auth', [
            'login' => $user->login,
            'password' => $user->password
        ]);

        $this->assertResponseIsSuccessful();
    }
}
