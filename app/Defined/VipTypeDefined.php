<?php

namespace App\Defined;

abstract class VipTypeDefined
{
    /** 訪客 (不具會員身分) */
    const VISITOR = 'VISITOR';
    
    /** 黃金會員 */
    const GOLD = 'GOLD';

    public static function all()
    {
        return [
            self::GOLD,
        ];
    }
}
