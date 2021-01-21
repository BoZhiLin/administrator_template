<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Date extends Model
{
    use HasFactory;

    protected $dates = [
        'opened_at',
        'closed_at',
    ];

    public function publisher()
    {
        return $this->belongsTo(User::class, 'publisher_id');
    }

    public function dateRecords()
    {
        return $this->hasMany(DateRecord::class);
    }
}
