<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Defined\ResponseDefined;

class AuthController extends AdminController
{
    public function login(Request $request)
    {
        $credentials = $request->only(['username', 'password']);
        $response = ['status' => ResponseDefined::SUCCESS];

        if (! $token = auth('admin')->attempt($credentials)) {
            $response['status'] = ResponseDefined::UNAUTHORIZED;
        } else {
            $token_info = $this->respondWithToken($token);
            $response['data'] = $token_info;
        }

        return response($response);
    }

    public function logout()
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        auth('admin')->logout();

        return response($response);
    }

    public function refresh()
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $token_info = $this->respondWithToken(auth('admin')->refresh());
        $response['data'] = $token_info;

        return response($response);
    }

    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expired_at' => strtotime(now()->addMinutes(config('jwt.ttl')))
        ];
    }
}
