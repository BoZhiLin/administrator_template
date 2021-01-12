<?php

namespace App\Repositories;

class AnnouncementRepository extends Repository
{
    public static function all()
    {
        return static::getModel()::get();
    }

    public static function create($data)
    {
        return static::getModel()::create($data);
    }

    public static function find(int $id)
    {
        return static::getModel()::find($id);
    }

    public static function getModel()
    {
        return \App\Models\Announcement::class;
    }
}
