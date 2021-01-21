<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DateRecord extends Model
{
    use HasFactory;

    public function date()
    {
        return $this->belongsTo(Date::class);
    }
}
