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

    /** 查無文章 */
    const POST_NOT_FOUND = 301;
    /** 已按過讚 */
    const POST_HAS_LIKE = 302;
    /** 未按過讚 */
    const POST_NOT_LIKE = 303;

    /** 今日已簽到 */
    const TODAY_HAS_SIGNED = 401;

    /** 查無公告 */
    const ANNOUNCEMENT_NOT_FOUND = 501;

    /** 查無Banner */
    const BANNER_NOT_FOUND = 601;

    /** 暫時無法新增約會 */
    const DATE_PUBLISH_NOT_ALLOW = 701;
    /** 查無約會 */
    const DATE_NOT_FOUND = 702;
    /** 不允許報名自己的約會 */
    const DATE_NOT_ALLOW_SELF = 703;
    /** 該約會已配對完畢 */
    const DATE_HAS_MATCHED = 704;
    /** 約會已結束 */
    const DATE_HAS_CLOSED = 705;
    /** 不可重複報名 */
    const DATE_HAS_SIGNUP = 706;
    /** 此配對人無報名該約會 */
    const DATE_MATCH_NOT_EXISTS = 707;
}
