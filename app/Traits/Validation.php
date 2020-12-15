<?php

namespace App\Traits;

use Illuminate\Support\Facades\Validator;

use App\Defined\ResponseDefined;

trait Validation
{
    public function validateRequest(array $request, array $validate, array $error = [])
    {
        $validator = Validator::make($request, $validate);
        $response = ['status' => ResponseDefined::SUCCESS];

        if ($validator->fails()) {
            $response['status'] = ResponseDefined::UNDEFINED_ARGUMENT;
            $msgs = $validator->messages();

            if (config('app.debug')) {
                $response['msg'] = $msgs;
            }

            foreach ($error as $key => $val) {
                $msg = $msgs->first($key);
                if (array_key_exists($msg, $error[$key])) {
                    $response['error'] = $error[$key][$msg];
                    break;
                }
            }
        }

        return $response;
    }
}
