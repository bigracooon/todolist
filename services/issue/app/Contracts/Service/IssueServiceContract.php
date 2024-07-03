<?php

namespace App\Contracts\Service;

use Illuminate\Database\Eloquent\Collection;

interface IssueServiceContract
{
    public function getIssues(): Collection;
}
