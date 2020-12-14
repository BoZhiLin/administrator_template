<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Defined\ResponseDefined;

class AuthController extends ApiController
{
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);
        $response = ['status' => ResponseDefined::SUCCESS];

        if (! $token = auth('api')->attempt($credentials)) {
            $response['status'] = ResponseDefined::UNAUTHORIZED;
        } else {
            $token_info = $this->respondWithToken($token);
            $response['data']['credential'] = $token_info;
        }

        return $response;
    }

    public function logout()
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        auth('api')->logout();

        return $response;
    }

    public function refresh()
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $token_info = $this->respondWithToken(auth('api')->refresh());
        $response['data']['credential'] = $token_info;

        return $response;
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
