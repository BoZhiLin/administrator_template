<?php

namespace App\Defined;

abstract class CoinDefined
{
    /** SUPER LIKE */
    const SUPER_LIKE = 'SUPER_LIKE';
    /** 每日LIKE數 (可配對數) */
    const DAY_LIKE = 'DAY_LIKE';

    public static function all()
    {
        return [
            self::SUPER_LIKE,
            self::DAY_LIKE,
        ];
    }
}
