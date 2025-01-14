<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Defined\ResponseDefined;

use App\Services\UserService;

class PasswordController extends ApiController
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function forgot(Request $request)
    {
        $response = $this->validateRequest($request->all(), [
            'email' => 'required|email'
        ]);

        if ($response['status'] === ResponseDefined::SUCCESS) {
            $response = $this->userService->forgetPassword($request->email);
        }

        return response($response);
    }

    public function reset(Request $request)
    {
        $response = $this->validateRequest($request->all(), [
            'password' => 'required|string|min:8'
        ]);

        if ($response['status'] === ResponseDefined::SUCCESS) {
            $response = $this->userService->resetPassword(auth()->id(), $request->password);
        }

        return response($response);
    }
}
