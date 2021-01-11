<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Defined\VipTypeDefined;
use App\Defined\ResponseDefined;

use App\Services\VipService;

class VipController extends ApiController
{
    /**
     * 購買
     */
    public function buy(Request $request)
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

    /**
     * 設定自動續訂 ON/OFF
     */
    public function autoRenewal(Request $request)
    {
        $result = $this->validateRequest($request->all(), [
            'status' => 'required|boolean'
        ]);

        if ($result['status'] === ResponseDefined::SUCCESS) {
            $user_id = auth()->id();
            VipService::autoRenewal($user_id, $request->status);
        }

        return response($result);
    }
}
