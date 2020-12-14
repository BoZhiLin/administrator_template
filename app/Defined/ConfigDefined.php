<?php

namespace App\Defined;

abstract class ConfigDefined
{
    // 會員
    /** 初始有效日 (天) */
    const DEFAULT_EXPIRED_IN = 'DEFAULT_EXPIRED_IN';

    /** 一般會員有效日 (天) */
    const GENERAL_EXPIRED_IN = 'GENERAL_EXPIRED_IN';

    public static function all()
    {
        return [
            self::DEFAULT_EXPIRED_IN,
            self::GENERAL_EXPIRED_IN
        ];
    }
}
