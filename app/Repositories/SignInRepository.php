<?php

namespace App\Repositories;

use App\Defined\TaskDefined;

class SignInRepository extends Repository
{
    public static function setByUser(int $user_id)
    {
        $model = static::getModel();
        $record = new $model();
        $record->user_id = $user_id;

        if ($yesterday_record = static::findByUser($user_id, today()->subDay()->toDateString())) {
            if ($yesterday_record->continuous >= TaskDefined::TARGET_CONTINUOUS_DAYS) {
                $record->continuous = 1;
            } else {
                $continuous = $yesterday_record->continuous;
                $continuous++;
                $record->continuous = $continuous;
            }
        } else {
            $record->continuous = 1;
        }

        $record->save();
        return $record;
    }

    /**
     * 某日是否簽到
     */
    public static function findByUser(int $user_id, string $date)
    {
        return static::getModel()::where('user_id', $user_id)
            ->whereDate('created_at', $date)
            ->first();
    }

    public static function getModel()
    {
        return \App\Models\SignIn::class;
    }
}
