<?php

namespace App\Defined;

abstract class ResponseDefined
{
    /** 成功 */
    const SUCCESS = 0;

    /** 登入失敗 */
    const UNAUTHORIZED = 101;
    /** 憑證非法 */
    const TOKEN_INVALID = 102;
    /** Token過期 */
    const TOKEN_EXPIRED = 103;
}
