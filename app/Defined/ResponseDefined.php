<?php

namespace App\Defined;

abstract class ResponseDefined
{
    /** 成功 */
    const SUCCESS = 0;

    /** 參數驗證有誤 */
    const UNDEFINED_ARGUMENT = 100;

    /** 登入失敗 */
    const UNAUTHORIZED = 101;
    /** 憑證非法 */
    const TOKEN_INVALID = 102;
    /** Token過期 */
    const TOKEN_EXPIRED = 103;
    /** 驗證碼失效 */
    const VERIFY_CODE_EXPIRED = 104;
    /** 驗證碼錯誤 */
    const VERIFY_CODE_ERROR = 105;
    /** 驗證碼不允許為空 */
    const VERIFY_CODE_REQUIRED = 106;

    /** 查無此帳號 */
    const USER_NOT_FOUND = 201;
    /** 信箱必填 */
    const EMAIL_REQUIRED = 202;
}
