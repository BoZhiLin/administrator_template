<?php

namespace App\Defined;

abstract class CoinDefined
{
    /** 會員點數 */
    const POINT = 'POINT';

    public static function all()
    {
        return [
            self::POINT
        ];
    }
}
