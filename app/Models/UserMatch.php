<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class UserMatch extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'is_matched' => 'boolean',
    ];

    protected $dates = [
        'matched_at',
        'deleted_at',
    ];
}
