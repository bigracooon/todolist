<?php

declare(strict_types=1);

namespace App\Tests\Feature;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BaseWebTestCase extends WebTestCase
{
    protected function tearDown(): void
    {
        restore_exception_handler();
        parent::tearDown();
    }
}
