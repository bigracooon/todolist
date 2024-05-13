<?php

namespace App\Tests\DataFixtures;

use App\Entity\User;
use App\Service\Hash\HashService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $hashService = new HashService();
        $password = $hashService->hash('12345678');

        $user = new User(
            fullname: 'Test User',
            login: 'test',
            password: $password
        );

        $manager->persist($user);
        $manager->flush();
    }
}