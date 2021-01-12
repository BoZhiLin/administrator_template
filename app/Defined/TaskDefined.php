<?php

namespace App\Defined;

abstract class TaskDefined
{
    /*
    |--------------------------------------------------------------------------
    | 任務清單
    |--------------------------------------------------------------------------
    */
    /** 每日簽到 */
    const TASK_SIGN_IN = 'SIGN_IN';
    /** 填寫完整個資 */
    const TASK_COMPLETED_PROFILE = 'COMPLETED_PROFILE';

    /*
    |--------------------------------------------------------------------------
    | 任務獎勵類別
    |--------------------------------------------------------------------------
    */
    /** 贈送VIP (天) */
    const REWARD_SEND_VIP = 'SEND_VIP';
    /** 贈送額外SUPER LIKE數 (不限制天數) */
    const REWARD_SEND_SUPER_LIKE = 'SEND_SUPER_LIKE';

    /*
    |--------------------------------------------------------------------------
    | 任務達成條件
    |--------------------------------------------------------------------------
    */
    /** 連續簽到的達成天數 */
    const TARGET_CONTINUOUS_DAYS = 5;

    /*
    |--------------------------------------------------------------------------
    | 任務達成獎勵
    |--------------------------------------------------------------------------
    */
    /** 連續簽到5日，贈送VIP的天數 */
    const GIFT_CONTINUOUS_VIP_DAYS = 3;
    /** 完整個資，贈送SUPER LIKE */
    const GIFT_PROFILE_SUPER_LIKE = 10;

    public static function tasks()
    {
        return [
            self::TASK_SIGN_IN,
            self::TASK_COMPLETED_PROFILE,
        ];
    }

    public static function rewards()
    {
        return [
            self::REWARD_SEND_VIP,
            self::REWARD_SEND_SUPER_LIKE,
        ];
    }
}
