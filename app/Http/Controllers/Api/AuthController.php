<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Defined\ResponseDefined;

class AuthController extends ApiController
{
    public function login(Request $request)
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $credentials = $this->credentials($request->all());

        if (! $token = auth()->attempt($credentials)) {
            $response['status'] = ResponseDefined::UNAUTHORIZED;
        } else {
            $token_info = $this->respondWithToken($token);
            $response['data']['is_verified'] = auth()->user()->is_verified;
            $response['data']['credential'] = $token_info;
        }

        return response($response);
    }

    public function logout()
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        auth()->logout();

        return response($response);
    }

    public function refresh()
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $token_info = $this->respondWithToken(auth()->refresh());
        $response['data']['credential'] = $token_info;

        return response($response);
    }

    protected function credentials(array $data)
    {
        return [
            'email' => $data['email'],
            'password' => $data['password']
        ];
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
