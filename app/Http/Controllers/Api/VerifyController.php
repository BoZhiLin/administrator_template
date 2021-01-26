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

    public function registration(Request $request)
    {
        $response = $this->userService->verifyUser(auth()->user(), $request->code);
        return response($response);
    }

    public function sendRegistration()
    {
        $response = $this->userService->sendVerifyCode(auth()->user());
        return response($response);
    }
}
