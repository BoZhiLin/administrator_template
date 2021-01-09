<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Defined\ResponseDefined;

use App\Services\UserService;

class UserController extends ApiController
{
    public function getInfo()
    {
        $user_info = UserService::getInfo(auth()->user());
        return response($user_info);
    }

    public function setInfo(Request $request)
    {
        $response = $this->validateRequest($request->all(), [
            'nickname' => 'required|string',
            'avatar' => 'nullable|image',
            'phone' => 'string',
            'introduction' => 'string|max:255',
            'blood' => 'string'
        ]);

        if ($response['status'] === ResponseDefined::SUCCESS) {
            $response = UserService::setInfo(auth()->user(), $request->only([
                'nickname',
                'avatar',
                'phone',
                'introduction',
                'blood',
                'constellation'
            ]));
        }
        
        return response($response);
    }
}
