<?php

namespace App\Models;

use App\Contracts\Model\IssueContract;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model implements IssueContract
{
    use HasFactory;

    protected $table = 'issue';
    protected $guarded = [];

    public function getAll(): Collection
    {
        return self::query()->get();
    }
}
