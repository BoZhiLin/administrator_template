<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasCode
{
    public function scopeOfCode(Builder $builder, string $code)
    {
        return $builder->where('code', $code);
    }
}
