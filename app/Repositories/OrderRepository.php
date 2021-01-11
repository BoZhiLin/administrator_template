<?php

namespace App\Repositories;

class OrderRepository extends Repository
{
    public static function create(array $data)
    {
        $model = static::getModel();
        $order = new $model();
        $order->user_id = $data['user_id'];
        $order->type = $data['type'];
        $order->amount = $data['amount'];
        $order->value = $data['value'];
        $order->status = $data['status'];
        
        if (isset($data['link'])) {
            $order->link = $order['link'];
        }

        if (isset($data['remark'])) {
            $order->remark = $order['remark'];
        }

        $order->save();
        return $order;
    }

    public static function getModel()
    {
        return \App\Models\Order::class;
    }
}
