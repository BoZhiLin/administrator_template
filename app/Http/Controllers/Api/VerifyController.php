<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Services\UserService;

class VerifyController extends ApiController
{
    public function registration(Request $request)
    {
        $user_id = auth()->id();
        $response = UserService::verifyUser($user_id, $request->code);
        return response($response);
    }

    public function sendRegistration()
    {
        $user_id = auth()->id();
        $response = UserService::sendVerifyCode($user_id);
        return response($response);
    }
}
