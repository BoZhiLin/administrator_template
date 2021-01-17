<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Defined\ResponseDefined;

class AuthController extends ApiController
{
    public function login(Request $request)
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $credentials = $request->only(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            $response['status'] = ResponseDefined::UNAUTHORIZED;
        } else {
            $response['data'] = $this->respondWithToken($token);
        }

        return response($response);
    }

    public function logout()
    {
        auth()->logout();
        return response(['status' => ResponseDefined::SUCCESS]);
    }

    public function refresh()
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $token_info = $this->respondWithToken(auth()->refresh());
        $response['data'] = $token_info;

        return response($response);
    }

    protected function respondWithToken($token)
    {
        return [
            'is_verified' => auth()->user()->is_verified,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expired_at' => strtotime(now()->addMinutes(config('jwt.ttl')))
        ];
    }
}
