<?php

namespace App\Defined;

abstract class TaskDefined
{
    /** 連續簽到的達成天數 */
    const TARGET_CONTINUOUS_DAYS = 5;

    /** 連續簽到5日，贈送VIP的天數 */
    const GIFT_CONTINUOUS_VIP_DAYS = 3;
}
