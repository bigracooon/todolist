<?php

namespace App\Http\Controllers;

use App\Contracts\Service\IssueServiceContract;
use Illuminate\Database\Eloquent\Collection;

final class IssueController extends Controller
{
    /**
     * @codeCoverageIgnore
     */
    public function __construct(
        private readonly IssueServiceContract $issueService
    ) {
    }

    public function index(): Collection
    {
        return $this->issueService->getIssues();
    }
}
