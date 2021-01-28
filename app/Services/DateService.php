<?php

namespace App\Services;

use Latrell\Lock\Facades\Lock;

use App\Defined\ResponseDefined;

use App\Repositories\UserRepository;
use App\Repositories\DateRepository;

class DateService extends Service
{
    protected $userRepo;
    protected $dateRepo;

    public function __construct(UserRepository $userRepo, DateRepository $dateRepo)
    {
        $this->userRepo = $userRepo;
        $this->dateRepo = $dateRepo;
    }
    
    /**
     * 取得開放報名中的約會
     * 
     * @return array
     */
    public function getOpeningList()
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $response['data']['dates'] = $this->dateRepo->getOpening();
        return $response;
    }

    /**
     * 取得約會明細
     * 
     * @param int $date_id
     * @return array
     */
    public function getDate(int $date_id)
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $date = $this->dateRepo->find($date_id);

        if (is_null($date)) {
            $response['status'] = ResponseDefined::DATE_NOT_FOUND;
        } else {
            $response['data']['date'] = $date;
        }

        return $response;
    }

    /**
     * 發佈約會
     * 
     * @param array $date_info (約會資訊)
     * @return array
     */
    public function publish(array $date_info)
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $last_date = $this->dateRepo->getLastByUser($date_info['publisher_id']);

        /** 一天內無法新增第二筆約會 */
        if (!is_null($last_date)) {
            $response['status'] = ResponseDefined::DATE_PUBLISH_NOT_ALLOW;
        } else {
            $date = $this->dateRepo->create($date_info);
            $response['data']['date'] = $date;
        }

        return $response;
    }

    /**
     * 報名
     * 
     * @param int $date_id (約會ID)
     * @param int $user_id (報名人ID)
     * @return array
     */
    public function signUp(int $date_id, int $user_id)
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $date = $this->dateRepo->find($date_id);

        if (is_null($date)) {
            $response['status'] = ResponseDefined::DATE_NOT_FOUND;
        } elseif ($date->publisher_id === $user_id) {
            $response['status'] = ResponseDefined::DATE_NOT_ALLOW_SELF;
        } elseif (!is_null($date->match_id)) {
            $response['status'] = ResponseDefined::DATE_HAS_MATCHED;
        } elseif (now() >= $date->closed_at) {
            $response['status'] = ResponseDefined::DATE_HAS_CLOSED;
        } elseif (
            $date->dateRecords->where('signup_user_id', $user_id)->count() > 0
        ) {
            $response['status'] = ResponseDefined::DATE_HAS_SIGNUP;
        } else {
            $lock_key = "sign@date_id:$date_id";

            try {
                Lock::acquire($lock_key);

                $date_record = $this->dateRepo->signUp($date, $user_id);
                $response['data']['record'] = $date_record;
            } finally {
                Lock::release($lock_key);
            }
        }

        return $response;
    }

    /**
     * 發佈人進行配對
     * 
     * @param int $date_id (約會ID)
     * @param int $user_id (當前使用者ID check用)
     * @param int $match_id (配對人ID)
     * @return array
     */
    public function match(int $date_id, int $user_id, int $match_id)
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $date = $this->dateRepo->find($date_id);

        if (is_null($date)) {
            $response['status'] = ResponseDefined::DATE_NOT_FOUND;
        } elseif ($date->publisher_id !== $user_id) {
            $response['status'] = ResponseDefined::PERMISSION_DENIED;
        } elseif (!is_null($date->match_id)) {
            $response['status'] = ResponseDefined::DATE_HAS_MATCHED;
        } elseif (! $match_user = $this->userRepo->find($match_id)) {
            $response['status'] = ResponseDefined::USER_NOT_FOUND;
        } elseif (! $record = $date->dateRecords->firstWhere('signup_user_id', $match_user->id)) {
            $response['status'] = ResponseDefined::DATE_MATCH_NOT_EXISTS;
        } else {
            $lock_key = "match@date_id:$date_id";

            try {
                Lock::acquire($lock_key);

                $record->is_matched = true;
                $record->save();

                $date = $record->date;
                $date->match_id = $match_id;
                $date->save();
            } finally {
                Lock::release($lock_key);
            }

            /** TODO: 通知配對人 */
        }

        return $response;
    }
}
