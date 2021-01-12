<?php

namespace App\Services;

use Illuminate\Support\Arr;

use App\Defined\TagDefined;
use App\Defined\TaskDefined;
use App\Defined\VipTypeDefined;
use App\Defined\ResponseDefined;

use App\Repositories\TagRepository;
use App\Repositories\VipRepository;
use App\Repositories\TaskRepository;
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
                TaskRepository::createRecordByUser($user_id, [
                    'code' => TaskDefined::TASK_SIGN_IN,
                    'reward_type' => TaskDefined::REWARD_SEND_VIP,
                    'reward_value' => TaskDefined::GIFT_CONTINUOUS_VIP_DAYS
                ]);
            }
        }

        return $response;
    }

    /**
     * 完整個資贈送SUPER LIKE
     */
    public static function completeProfile(int $user_id, array $data)
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $full_fields = ['nickname', 'avatar', 'phone', 'introduction', 'blood'];

        /** 完整填寫個資，給予註記，並贈送SUPER LIKE */
        if (Arr::has($data, $full_fields)) {
            $completed_tag = TagRepository::getByUser($user_id, TagDefined::PROFILE_COMPLETED);

            if (is_null($completed_tag)) {
                TagRepository::setByUser($user_id, TagDefined::PROFILE_COMPLETED);
                TaskRepository::createRecordByUser($user_id, [
                    'code' => TaskDefined::TASK_COMPLETED_PROFILE,
                    'reward_type' => TaskDefined::REWARD_SEND_SUPER_LIKE,
                    'reward_value' => TaskDefined::GIFT_PROFILE_SUPER_LIKE
                ]);
                // TODO:Wallet & Transaction
            }
        }

        return $response;
    }
}
