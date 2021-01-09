<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Defined\ResponseDefined;

use App\Services\UserService;

class PasswordController extends ApiController
{
    public function forgot(Request $request)
    {
        $response = $this->validateRequest($request->all(), [
            'email' => 'required|email'
        ]);

        if ($response['status'] === ResponseDefined::SUCCESS) {
            $response = UserService::forgetPassword($request->email);
        }

        return response($response);
    }

    public function reset(Request $request)
    {
        $response = $this->validateRequest($request->all(), [
            'password' => 'required|string|min:8'
        ]);

        if ($response['status'] === ResponseDefined::SUCCESS) {
            $user_id = auth()->id();
            $response = UserService::resetPassword($user_id, $request->password);
        }

        return response($response);
    }
}
