<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Defined\GenderDefined;
use App\Defined\ResponseDefined;

use App\Services\UserService;

class UserController extends ApiController
{
    public function register(Request $request)
    {
        $genders = implode(',', GenderDefined::all());
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
            $response = UserService::setInfo(auth()->id(), $request->only([
                'nickname',
                'avatar',
                'phone',
                'introduction',
                'blood'
            ]));
        }
        
        return response($response);
    }
}
