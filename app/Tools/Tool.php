<?php

namespace App\Tools;

use Exception;
use Carbon\Carbon;
use App\Defined\ConstellationDefined;

class Tool
{
    /**
     * 星座判斷
     * 
     * @param string $date
     * @return string $constellation
     */
    public static function getConstellation(string $date)
    {
        $date_arr = explode('-', $date);

        if (!checkdate($date_arr[1], $date_arr[2], $date_arr[0])) {
            throw new Exception('Date is invalid');
        }

        $born = date('md', strtotime($date));

        if ($born >= 121 && $born <= 219) {
            $constellation = ConstellationDefined::AQUARIUS;
        } elseif ($born >= 220 && $born <= 320) {
            $constellation = ConstellationDefined::PISCES;
        } elseif ($born >= 321 && $born <= 419) {
            $constellation = ConstellationDefined::ARIES;
        } elseif ($born >= 420 && $born <= 520) {
            $constellation = ConstellationDefined::TAURUS;
        } elseif ($born >= 521 && $born <= 621) {
            $constellation = ConstellationDefined::GEMINI;
        } elseif ($born >= 622 && $born <= 722) {
            $constellation = ConstellationDefined::CANCER;
        } elseif ($born >= 723 && $born <= 822) {
            $constellation = ConstellationDefined::LEO;
        } elseif ($born >= 823 && $born <= 922) {
            $constellation = ConstellationDefined::VIRGO;
        } elseif ($born >= 923 && $born <= 1023) {
            $constellation = ConstellationDefined::LIBRA;
        } elseif ($born >= 1024 && $born <= 1121) {
            $constellation = ConstellationDefined::SCORPIO;
        } elseif ($born >= 1122 && $born <= 1220) {
            $constellation = ConstellationDefined::SAGITTARIUS;
        } elseif (($born >= 1221 && $born <= 1231) || ($born >= 101 && $born <= 120)) {
            $constellation = ConstellationDefined::CAPRICORN;
        }

        return $constellation;
    }

    /**
     * 計算年齡
     * 
     * @param string $date
     * @return int
     */
    public static function getAge(string $date)
    {
        return Carbon::now()->diffInYears(Carbon::parse($date));
    }
}
