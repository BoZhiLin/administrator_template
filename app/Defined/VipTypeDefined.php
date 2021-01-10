<?php

namespace App\Defined;

abstract class VipTypeDefined
{
    /** 訪客 (不具會員身分) */
    const VISITOR = 'VISITOR';
    
    /** 一般會員 */
    const GENERAL = 'GENERAL';

    /** 黃金會員 */
    const GOLD = 'GOLD';

    public static function all()
    {
        return [
            self::GENERAL,
            self::GOLD,
        ];
    }
}
