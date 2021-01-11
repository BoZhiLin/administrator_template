<?php

namespace App\Services;

use App\Defined\TagDefined;
use App\Defined\SystemDefined;
use App\Defined\VipTypeDefined;
use App\Defined\ResponseDefined;
use App\Defined\OrderTypeDefined;
use App\Defined\OrderStatusDefined;

use App\Repositories\VipRepository;
use App\Repositories\TagRepository;
use App\Repositories\OrderRepository;

class VipService extends Service
{
    public static function buy(int $user_id, string $type)
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $order_types = [
            VipTypeDefined::GENERAL => OrderTypeDefined::BUY_GENERAL_VIP,
            VipTypeDefined::GOLD => OrderTypeDefined::BUY_GOLD_VIP
        ];
        $prices = [
            VipTypeDefined::GENERAL => SystemDefined::GENERAL_VIP_PRICE,
            VipTypeDefined::GOLD => SystemDefined::GENERAL_VIP_PRICE
        ];
        $order_info = [
            'user_id' => $user_id,
            'type' => $order_types[$type],
            'amount' => 1,
            'value' => $prices[$type],
            'status' => OrderStatusDefined::PAYING
        ];

        $order = OrderRepository::create($order_info);
        VipRepository::buyByUser($user_id, $type, SystemDefined::VIP_EXPIRES_DAYS);
        /** 串金流 TODO */

        return $response;
    }

    /**
     * 設定自動續訂 ON/OFF
     */
    public static function autoRenewal(int $user_id, bool $status = true)
    {
        $response = ['status' => ResponseDefined::SUCCESS];

        if ($status === true) {
            TagRepository::setByUser($user_id, TagDefined::VIP_AUTO_RENEWAL);
        } else {
            TagRepository::removeByUser($user_id, TagDefined::VIP_AUTO_RENEWAL);
        }

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
