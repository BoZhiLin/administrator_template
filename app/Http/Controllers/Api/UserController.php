<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Defined\ResponseDefined;

use App\Services\VipService;
use App\Services\UserService;
use App\Services\TaskService;

class UserController extends ApiController
{
    public function register(Request $request)
    {
        $genders = implode(',', ['MALE', 'FEMALE', 'OTHER']);
        $response = $this->validateRequest($request->all(), [
            'name' => ['required', 'max:100'],
            'birthday' => ['required', 'date_format:Y-m-d'],
            'gender' => ['required', "in:$genders"],
            'nickname' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:8']
        ], [
            'name' => [
                'Required' => ResponseDefined::NAME_REQUIRED,
                'Max' => ResponseDefined::NAME_MAX,
            ],
            'birthday' => [
                'Required' => ResponseDefined::BIRTHDAY_REQUIRED,
                'DateFormat' => ResponseDefined::BIRTHDAY_INVALID
            ],
            'gender' => [
                'Required' => ResponseDefined::GENDER_REQUIRED,
                'In' => ResponseDefined::GENDER_INVALID
            ],
            'nickname' => [
                'Required' => ResponseDefined::NICKNAME_REQUIRED
            ],
            'email' => [
                'Required' => ResponseDefined::EMAIL_REQUIRED,
                'Email' => ResponseDefined::EMAIL_INVALID,
                'Unique' => ResponseDefined::EMAIL_HAS_EXISTS
            ],
            'password' => [
                'Required' => ResponseDefined::PASSWORD_REQUIRED,
                'Min' => ResponseDefined::PASSWORD_MIN
            ]
        ]);

        if ($response['status'] === ResponseDefined::SUCCESS) {
            $response = UserService::register($request->only([
                'name',
                'birthday',
                'gender',
                'nickname',
                'email',
                'password'
            ]));
        }

        return response($response);
    }

    public function getInfo()
    {
        $user_info = UserService::getInfo(auth()->id());
        return response($user_info);
    }

    public function setInfo(Request $request)
    {
        $bloods = implode(',', ['A', 'B', 'AB', 'O']);
        $response = $this->validateRequest($request->all(), [
            'nickname' => 'required|string',
            'avatar' => 'nullable|image',
            'phone' => 'string',
            'introduction' => 'string|max:255',
            'blood' => "string|in:$bloods"
        ]);

        if ($response['status'] === ResponseDefined::SUCCESS) {
            $user_id = auth()->id();
            $data = $request->only([
                'nickname',
                'avatar',
                'phone',
                'introduction',
                'blood'
            ]);

            $response = UserService::setInfo($user_id, $data);
            $response = TaskService::completeProfile($user_id, $data);
        }
        
        return response($response);
    }

    public function buyVIP()
    {
        $user_id = auth()->id();
        $result = VipService::buy($user_id);

        /** TODO 串金流時改為回傳支付form */
        return response($result);
    }

    public function signIn()
    {
        $response = TaskService::signIn(auth()->id());
        return response($response);
    }
}
