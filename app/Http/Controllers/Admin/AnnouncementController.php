<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Defined\ResponseDefined;

use App\Services\AnnouncementService;

class AnnouncementController extends AdminController
{
    public function index()
    {
        $response = AnnouncementService::getAnnouncements(true);
        return response($response);
    }

    public function show(int $id)
    {
        $response = AnnouncementService::getAnnouncement($id);
        return response($response);
    }

    public function store(Request $request)
    {
        $response = $this->validateRequest($request->all(), [
            'title' => 'required',
            'content' => 'required',
            'started_at' => 'date_format:Y-m-d H:i:s',
            'ended_at' => 'date_format:Y-m-d H:i:s'
        ]);
        
        if ($response['status'] === ResponseDefined::SUCCESS) {
            $response = AnnouncementService::createAccouncement($request->only([
                'title',
                'content',
                'started_at',
                'ended_at'
            ]));
        }
        
        return response($response);
    }

    public function update(int $id, Request $request)
    {
        $response = $this->validateRequest($request->all(), [
            'title' => 'required',
            'content' => 'required',
            'started_at' => 'date_format:Y-m-d H:i:s',
            'ended_at' => 'date_format:Y-m-d H:i:s'
        ]);

        if ($response['status'] === ResponseDefined::SUCCESS) {
            $response = AnnouncementService::updateAnnouncement($id, $request->only([
                'title',
                'content',
                'started_at',
                'ended_at'
            ]));
        }

        return response($response);
    }

    public function destroy(int $id)
    {
        $response = AnnouncementService::removeAnnouncement($id);
        return response($response);
    }
}
