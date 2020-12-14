<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

use App\Jobs\SendVerifyMail;

use App\Defined\ResponseDefined;

use App\Repositories\UserRepository;

class UserService extends Service
{
    protected $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function getAllUsers()
    {
        return $this->userRepo->all();
    }

    public function getUser(int $user_id)
    {
        return $this->userRepo->find($user_id);
    }

    /**
     * 前台註冊會員
     * 
     * @param array $data
     */
    public function register(array $data)
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $user = $this->userRepo->create($data);
        
        SendVerifyMail::dispatch($user->email);

        return $response;
    }

    /**
     * 取得登入會員資訊
     * 
     * @return array
     */
    public function getInfo()
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $user = auth('api')->user();

        if (is_null($user)) {
            $response['status'] = ResponseDefined::USER_NOT_FOUND;
        } else {
            $response['data']['user'] = [
                'id' => $user->id,
                'name' => $user->name,
                'nickname' => $user->nickname,
                'email' => $user->email,
                'avatar' => $user->avatar,
                'phone' => $user->phone,
                'expired_at' => $user->expired_at
            ];
        }

        return $response;
    }
}
