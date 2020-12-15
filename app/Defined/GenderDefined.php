<?php

namespace App\Defined;

abstract class GenderDefined
{
    /** 男性 */
    const MALE = 'MALE';
    /** 女性 */
    const FEMALE = 'FEMALE';
    /** 其他 */
    const OTHER = 'OTHER';

    public static function all()
    {
        return [
            self::MALE,
            self::FEMALE,
            self::OTHER
        ];
    }
}
