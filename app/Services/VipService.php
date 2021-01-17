<?php

namespace App\Services;

use App\Defined\SystemDefined;
use App\Defined\ResponseDefined;
use App\Defined\OrderTypeDefined;
use App\Defined\OrderStatusDefined;

use App\Repositories\VipRepository;
use App\Repositories\OrderRepository;

class VipService extends Service
{
    public static function buy(int $user_id, string $type = null)
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $order_info = [
            'user_id' => $user_id,
            'type' => OrderTypeDefined::BUY_GOLD_VIP,
            'amount' => 1,
            'value' => SystemDefined::GOLD_VIP_PRICE,
            'status' => OrderStatusDefined::PAYING
        ];

        $order = OrderRepository::create($order_info);
        VipRepository::buyByUser($user_id, $type, SystemDefined::VIP_EXPIRES_DAYS);
        /** 串金流 TODO */

        return $response;
    }

    /**
     * 完成付款 (留著以後金流webhook用)
     */
    public static function completed()
    {
        // $response = ['status' => ResponseDefined::SUCCESS];
        // VipRepository::buyByUser($user_id, $type, SystemDefined::VIP_EXPIRES_DAYS);
    }
}
