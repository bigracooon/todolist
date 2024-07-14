<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class IssueControllerTest extends TestCase
{
    #[Test]
    public function successGettingIssues(): void
    {
        $token = config('testing.token');
        $response = $this->get(route('issues.index') . "?token=" . $token);
        $response->assertStatus(200);
    }

    #[Test]
    public function forbiddenGettingIssues(): void
    {
        $invalidToken = 'ngkldjhfgasf.lksjdhfksdc.sdjfhdfs';
        $response = $this->get(route('issues.index') . "?token=" . $invalidToken);
        $response->assertStatus(403);
    }
}
