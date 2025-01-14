<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Defined\ResponseDefined;

use App\Services\DateService;

class DateController extends ApiController
{
    protected $dateService;

    public function __construct(DateService $dateService)
    {
        $this->dateService = $dateService;
    }

    /** TODO: 配對後是否成為好友? 要能看自己的配對紀錄? 被配對到的人要能查看約會資料 */
    public function getOpeningList()
    {
        $response = $this->dateService->getOpeningList();
        return response($response);
    }

    public function getDetail(int $id)
    {
        $response = $this->dateService->getDate($id);
        return response($response);
    }

    public function publish(Request $request)
    {
        $result = $this->validateRequest($request->all(), [
            'title' => 'required|string|max:30',
            'description' => 'required|string|max:50'
        ]);

        if ($result['status'] === ResponseDefined::SUCCESS) {
            $date_info = $request->only(['title', 'description']);
            $date_info['publisher_id'] = auth()->id();
            $result = $this->dateService->publish($date_info);
        }

        return response($result);
    }

    public function signUp(int $id)
    {
        $response = $this->dateService->signUp($id, auth()->id());
        return response($response);
    }

    public function match(Request $request, int $id)
    {
        $result = $this->validateRequest($request->all(), [
            'match_id' => 'required'
        ]);

        if ($result['status'] === ResponseDefined::SUCCESS) {
            $result = $this->dateService->match($id, auth()->id(), $request->match_id);
        }

        return response($result);
    }
}
