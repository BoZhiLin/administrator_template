<?php

namespace App\Repositories;

use App\Models\Date;

class DateRepository extends Repository
{
    public function getOpening()
    {
        $now = now();
        return $this->getModel()::where('opened_at', '<=', $now)
            ->where('closed_at', '>', $now)
            ->with(['publisher' => function ($query) {
                $query->select('users.id', 'name', 'nickname', 'avatar');
            }])
            ->get();
    }

    public function create(array $info)
    {
        $now = now();
        $model = $this->getModel();
        $date = new $model();
        $date->title = $info['title'];
        $date->description = $info['description'];
        $date->publisher_id = $info['publisher_id'];
        $date->opened_at = $now;
        $date->closed_at = $now->addDay();
        $date->save();

        return $date;
    }

    public function signUp(Date $date, int $user_id)
    {
        return $date->dateRecords()->create(['signup_user_id' => $user_id]);
    }

    public function find(int $id)
    {
        return $this->getModel()::where('id', $id)
            ->with(['dateRecords', 'publisher' => function ($query) {
                $query->select('users.id', 'name', 'nickname', 'avatar');
            }])
            ->first();
    }

    /**
     * 24小時內，只能建立一次約會
     */
    public function getLastByUser(int $user_id)
    {
        $now = now();
        $last_date = $this->getModel()::where('publisher_id', $user_id)
            ->where('created_at', '>=', $now->subDay())
            ->first();

        return $last_date;
    }

    public function getModel()
    {
        return Date::class;
    }
}
