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
}