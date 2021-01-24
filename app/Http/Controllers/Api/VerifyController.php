<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Services\UserService;

class VerifyController extends ApiController
{
    public function registration(Request $request)
    {
        $response = UserService::verifyUser(auth()->user(), $request->code);
        return response($response);
    }

    public function sendRegistration()
    {
        $response = UserService::sendVerifyCode(auth()->user());
        return response($response);
    }
}
