<?php

namespace App\Repositories;

class ConfigRepository extends Repository
{
    public static function getByType(string $type)
    {
        return static::getModel()::where('type', $type)->first();
    }

    public static function getModel()
    {
        return \App\Models\Config::class;
    }
}
