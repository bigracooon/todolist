<?php

namespace Tests\Unit\Service;

use App\Contracts\Model\IssueContract;
use App\Contracts\Service\IssueServiceContract;
use App\Service\IssueService;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class IssueServiceTest extends TestCase
{
    private readonly IssueServiceContract $issueService;
    private readonly IssueContract $issue;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->issue = $this->createMock(IssueContract::class);
        $this->issueService = new IssueService($this->issue);
        parent::setUp();
    }

    #[Test]
    public function getIssues()
    {
        $this->issue->expects($this->once())->method('getAll');
        $this->issueService->getIssues();
    }
}
