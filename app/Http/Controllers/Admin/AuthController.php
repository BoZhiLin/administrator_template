<?php

namespace App\Http\Controllers\Admin;

use App\Defined\ResponseDefined;

class AuthController extends AdminController
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin.log', ['only' => ['login', 'logout', 'refresh']]);
        $this->middleware('admin.auth', ['only' => ['me', 'logout', 'refresh']]);
    }

    public function login()
    {
        $credentials = request(['username', 'password']);
        $response = ['status' => ResponseDefined::SUCCESS];

        if (! $token = auth('admin')->attempt($credentials)) {
            $response['status'] = ResponseDefined::UNAUTHORIZED;
        } else {
            $token_info = $this->respondWithToken($token);
            $response['data']['credential'] = $token_info;
        }

        return $response;
    }

    public function me()
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $response['data']['user'] = auth('admin')->user();

        return $response;
    }

    public function logout()
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        auth('admin')->logout();

        return $response;
    }

    public function refresh()
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $token_info = $this->respondWithToken(auth('admin')->refresh());
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
