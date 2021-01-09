<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Services\UserService;

class VerifyController extends ApiController
{
    /**
     * 註冊 驗證碼
     */
    public function registration(Request $request)
    {
        $user_id = auth('')->id();
        $response = UserService::verifyUser($user_id, $request->code);
        return response($response);
    }

    /**
     * 註冊 寄發驗證碼
     */
    public function sendRegistration()
    {
        $user_id = auth('')->id();
        $response = UserService::sendVerifyCode($user_id);
        return response($response);
    }
}
