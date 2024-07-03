<?php

declare(strict_types=1);

namespace App\Service;

use App\Contracts\Model\IssueContract;
use App\Contracts\Service\IssueServiceContract;
use Illuminate\Database\Eloquent\Collection;

final readonly class IssueService implements IssueServiceContract
{
    /**
     * @codeCoverageIgnore
     */
    public function __construct(
        private IssueContract $issue
    ) {
    }

    public function getIssues(): Collection
    {
        return $this->issue->getAll();
    }
}
