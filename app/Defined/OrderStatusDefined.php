<?php

namespace App\Defined;

abstract class OrderStatusDefined
{
    /** 待付款 */
    const PAYING = 'PAYING';

    /** 已付款 */
    const COMPLETED = 'COMPLETED';

    /** 取消 */
    const CANCEL = 'CANCEL';
}