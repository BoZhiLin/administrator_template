<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Defined\ResponseDefined;
use App\Defined\ConstellationDefined;

use App\Services\UserService;

class UserController extends ApiController
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function getInfo()
    {
        $user_info = $this->userService->getInfo(auth('api')->user());
        return response($user_info);
    }

    public function setInfo(Request $request)
    {
        $constellations = implode(',', ConstellationDefined::all());
        $response = $this->validateRequest($request->all(), [
            'nickname' => 'required|string',
            'avatar' => 'nullable|image',
            'phone' => 'string',
            'introduction' => 'string|max:255',
            'blood' => 'string',
            'constellation' => "string|in:$constellations"
        ]);

        if ($response['status'] === ResponseDefined::SUCCESS) {
            $response = $this->userService->setInfo(auth('api')->user(), $request->only([
                'nickname',
                'avatar',
                'phone',
                'introduction',
                'blood',
                'constellation'
            ]));
        }
        
        return $response;
    }
}
