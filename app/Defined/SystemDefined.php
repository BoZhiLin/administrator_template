<?php

namespace App\Defined;

abstract class SystemDefined
{
    /** 驗證碼時效 (分) */
    const VERIFY_CODE_EXPIRED = 3;

    /** 會員預設期限 (天) */
    const USER_DEFAULT_DAYS = 3;

    /** VIP有效天數 */
    const VIP_EXPIRES_DAYS = 30;

    /** 一般VIP單價 */
    const GENERAL_VIP_PRICE = 499;

    /** 黃金VIP 單價 */
    const GOLD_VIP_PRICE = 799;

    /** 會員到期通知天數 (N天前) */
    const EXPIRATION_NOTIFY_DAYS = 3;
}
