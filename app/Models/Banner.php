<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = [
        'deleted_at',
    ];

    protected $fillable = [
        'started_at',
        'ended_at',
        'path',
        'target_url',
        'sort',
    ];
}
