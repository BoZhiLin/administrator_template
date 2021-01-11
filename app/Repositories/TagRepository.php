<?php

namespace App\Repositories;

class TagRepository extends Repository
{
    public static function setByUser(int $user_id, string $type)
    {
        static::getModel()::firstOrCreate([
            'user_id' => $user_id,
            'type' => $type
        ]);
    }

    public static function getByUser(int $user_id, string $type)
    {
        return static::getModel()::where('user_id', $user_id)
            ->where('type', $type)
            ->first();
    }

    public static function getModel()
    {
        return \App\Models\Tag::class;
    }
}
