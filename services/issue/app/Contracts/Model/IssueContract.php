<?php

namespace App\Contracts\Model;

use Illuminate\Database\Eloquent\Collection;

interface IssueContract
{
    public function getAll(): Collection;
}
