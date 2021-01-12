<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

use App\Traits\HasCode;

class Task extends Model
{
    use HasFactory, SoftDeletes, HasCode;

    protected $dates = [
        'started_at',
        'ended_at',
        'deleted_at',
    ];

    public function taskRecords()
    {
        return $this->hasMany(TaskRecord::class);
    }
}
