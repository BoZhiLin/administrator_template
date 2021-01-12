<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

use App\Traits\HasCode;

class TaskRecord extends Model
{
    use HasFactory, SoftDeletes, HasCode;

    protected $dates = [
        'completed_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'task_id',
        'reward_type',
        'reward_value',
        'link',
        'completed_at',
    ];
}
