<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Services\UserService;

class VerifyController extends ApiController
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * 註冊 驗證碼
     */
    public function registration(Request $request)
    {
        $user_id = auth('api')->id();
        $response = $this->userService->verifyUser($user_id, $request->code);
        return response($response);
    }

    /**
     * 註冊 寄發驗證碼
     */
    public function sendRegistration()
    {
        $user_id = auth('api')->id();
        $response = $this->userService->sendVerifyCode($user_id);
        return response($response);
    }
}
