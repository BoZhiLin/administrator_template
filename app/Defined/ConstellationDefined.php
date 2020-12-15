<?php

namespace App\Defined;

abstract class ConstellationDefined
{
    /** 水瓶 */
    const AQUARIUS = 'AQUARIUS';
    /** 雙魚 */
    const PISCES = 'PISCES';
    /** 牡羊 */
    const ARIES = 'ARIES';
    /** 金牛 */
    const TAURUS = 'TAURUS';
    /** 雙子 */
    const GEMINI = 'GEMINI';
    /** 巨蟹 */
    const CANCER = 'CANCER';
    /** 獅子 */
    const LEO = 'LEO';
    /** 處女 */
    const VIRGO = 'VIRGO';
    /** 天秤 */
    const LIBRA = 'LIBRA';
    /** 天蠍 */
    const SCORPIO = 'SCORPIO';
    /** 射手 */
    const SAGITTARIUS = 'SAGITTARIUS';
    /** 魔羯 */
    const CAPRICORN = 'CAPRICORN';

    public static function all()
    {
        return [
            self::AQUARIUS,
            self::PISCES,
            self::ARIES,
            self::TAURUS,
            self::GEMINI,
            self::CANCER,
            self::LEO,
            self::VIRGO,
            self::LIBRA,
            self::SCORPIO,
            self::SAGITTARIUS,
            self::CAPRICORN
        ];
    }
}
