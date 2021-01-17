<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Defined\VipTypeDefined;
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
            'name' => ['required', 'string', 'max:255'],
            'birthday' => ['required', 'date_format:Y-m-d'],
            'gender' => ['required', "in:$genders"],
            'nickname' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            // 'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password' => ['required', 'string', 'min:8']
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

    public function buyVIP(Request $request)
    {
        $vips = implode(',', VipTypeDefined::all());
        $result = $this->validateRequest($request->all(), [
            'type' => "required|in:$vips"
        ]);

        if ($result['status'] === ResponseDefined::SUCCESS) {
            $user_id = auth()->id();
            $result = VipService::buy($user_id, $request->type);
        }

        /** TODO 串金流時改為回傳支付form */
        return response($result);
    }
}
