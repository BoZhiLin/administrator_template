<?php

namespace App\Repositories;

class VipRepository extends Repository
{
    public static function buyByUser(int $user_id, string $type, int $days = 30)
    {
        $now = now();
        $vip = static::getModel()::where('user_id', $user_id)
            ->where('type', $type)
            ->first();
        
        if (is_null($vip)) {
            $model = static::getModel();
            $vip = new $model();
            $vip->user_id = $user_id;
            $vip->type = $type;
            $vip->expired_at = $now->addDays($days);
        } else {
            if ($vip->expired_at >= $now) {
                $vip->expired_at = $now->addDays($days);
            } else {
                $vip->expired_at = $vip->expired_at->addDays($days);
            }
        }

        $vip->save();
    }

    public static function getModel()
    {
        return \App\Models\Vip::class;
    }
}
