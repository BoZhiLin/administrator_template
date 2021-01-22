<?php

namespace App\Repositories;

use App\Models\Date;

class DateRepository extends Repository
{
    public static function getOpening()
    {
        $now = now();
        return static::getModel()::where('opened_at', '<=', $now)
            ->where('closed_at', '>', $now)
            ->with(['publisher' => function ($query) {
                $query->select('users.id', 'name', 'nickname', 'avatar');
            }])
            ->get();
    }

    public static function create(array $info)
    {
        $now = now();
        $model = static::getModel();
        $date = new $model();
        $date->title = $info['title'];
        $date->description = $info['description'];
        $date->publisher_id = $info['publisher_id'];
        $date->opened_at = $now;
        $date->closed_at = $now->addDay();
        $date->save();

        return $date;
    }

    public static function signUp(Date $date, int $user_id)
    {
        return $date->dateRecords()->create(['signup_user_id' => $user_id]);
    }

    public static function find(int $id)
    {
        return static::getModel()::where('id', $id)
            ->with(['dateRecords', 'publisher' => function ($query) {
                $query->select('users.id', 'name', 'nickname', 'avatar');
            }])
            ->first();
    }

    /**
     * 24小時內，只能建立一次約會
     */
    public static function getLastByUser(int $user_id)
    {
        $now = now();
        $last_date = static::getModel()::where('publisher_id', $user_id)
            ->where('created_at', '>=', $now->subDay())
            ->first();

        return $last_date;
    }

    public static function getModel()
    {
        return Date::class;
    }
}
