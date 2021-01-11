<?php

namespace App\Services;

use App\Defined\TaskDefined;
use App\Defined\VipTypeDefined;
use App\Defined\ResponseDefined;

use App\Repositories\VipRepository;
use App\Repositories\SignInRepository;

class TaskService extends Service
{
    /**
     * 簽到
     */
    public static function signIn(int $user_id)
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $today_record = SignInRepository::findByUser($user_id, today()->toDateString());

        if (!is_null($today_record)) {
            $response['status'] = ResponseDefined::TODAY_HAS_SIGNED;
        } else {
            $record = SignInRepository::setByUser($user_id);

            /** 連續簽到5日，贈送3天VIP */
            if ($record->continuous === TaskDefined::TARGET_CONTINUOUS_DAYS) {
                VipRepository::buyByUser($user_id, VipTypeDefined::GENERAL, TaskDefined::GIFT_CONTINUOUS_VIP_DAYS);
            }
        }

        return $response;
    }
}
