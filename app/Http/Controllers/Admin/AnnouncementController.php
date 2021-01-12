<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Services\AnnouncementService;
use App\Http\Controllers\Api\ApiController;
use App\Defined\ResponseDefined;

class AnnouncementController extends ApiController
{
    
    public function index()
    {
        return AnnouncementService::all();
    }

    public function store(Request $request)
    {
        $response = $this->validateRequest($request->all(), $this->rules(), $this->messages());
        
        if ($response['status'] === ResponseDefined::SUCCESS) {
            $response = AnnouncementService::create($request->only([
                'title',
                'content',
                'started_at',
                'ended_at',
            ]));
        }
        
        return response($response);
    }

    public function destroy($id)
    {
        $response['data']['announcement'] = AnnouncementService::find($id)->delete();
       
        if ($response) {
            $response['status'] = ResponseDefined::SUCCESS;
            return response($response);
        }
    }

    public function update($id, Request $request)
    {
        $response = $this->validateRequest($request->all(), $this->rules(), $this->messages());

        if ($response['status'] === ResponseDefined::SUCCESS) {
            $response['data']['announcement'] = AnnouncementService::find($id)->update($request->only([
                'title',
                'content',
                'started_at',
                'ended_at',
            ]));
        }

        return response($response);
    }

    public function rules()
    {
        return  [
            'title' => 'required',
            'content' => 'required',
            'started_at' => 'required|date_format:Y-m-d H:i:s',
            'ended_at' => 'required|date_format:Y-m-d H:i:s',
        ];
    }

    public function messages()
    {
        return  [
            'title.required' => 'The :attribute field is required.',
            'content.required' => 'The :attribute field is required.',
            'started_at.required' => 'The :attribute field is required.',
            'ended_at.required' => 'The :attribute field is required.',
            'started_at.date_format'=> 'The :attribute is not a valid date_format.',
            'ended_at.date_format'=> 'The :attribute is not a valid date_format.'
        ];
    }

}
