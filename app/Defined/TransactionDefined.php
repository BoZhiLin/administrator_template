<?php

namespace App\Defined;

abstract class TransactionDefined
{
    /** 管理者操作 */
    const ADMIN = 'ADMIN';
    /** 完成任務，系統發送 */
    const TASK = 'TASK';
    /** 系統補償 */
    const SYSTEM_RECOUP = 'SYSTEM_RECOUP';
    /** 系統每日發放 */
    const SYSTEM_SEND_DAILY = 'SYSTEM_SEND_DAILY';
    /** 發送LIKE */
    const SEND_LIKE = 'SEND_LIKE';
}