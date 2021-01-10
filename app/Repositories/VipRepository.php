<?php

namespace App\Repositories;

use App\Defined\VipTypeDefined;

class VipRepository extends Repository
{
    public static function buyByUser(int $user_id, string $type, int $days)
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

    public static function getLevelsByUser(int $user_id)
    {
        $now = now();
        $levels = [
            'general_expired_at' => null,
            'gold_expired_at' => null
        ];
        $vips = static::getModel()::where('user_id', $user_id)
            ->whereIn('type', VipTypeDefined::all())
            ->get();

        if (
            $vips->firstWhere('type', VipTypeDefined::GOLD) &&
            $vips->firstWhere('type', VipTypeDefined::GOLD)->expired_at < $now
        ) {
            $levels['gold_expired_at'] = $vips->firstWhere('type', VipTypeDefined::GOLD)->expired_at;
        }

        if (
            $vips->firstWhere('type', VipTypeDefined::GENERAL) &&
            $vips->firstWhere('type', VipTypeDefined::GENERAL)->expired_at < $now
        ) {
            $levels['general_expired_at'] = $vips->firstWhere('type', VipTypeDefined::GENERAL)->expired_at;
        }

        return $levels;
    }

    public static function getModel()
    {
        return \App\Models\Vip::class;
    }
}
