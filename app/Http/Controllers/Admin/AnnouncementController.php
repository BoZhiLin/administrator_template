<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Defined\ResponseDefined;

use App\Services\AnnouncementService;

class AnnouncementController extends AdminController
{
    protected $announcementService;

    public function __construct(AnnouncementService $announcementService)
    {
        $this->announcementService = $announcementService;
    }

    public function index()
    {
        $response = $this->announcementService->getAnnouncements(true);
        return response($response);
    }

    public function show(int $id)
    {
        $response = $this->announcementService->getAnnouncement($id);
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
            $response = $this->announcementService->createAccouncement($request->only([
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
            $response = $this->announcementService->updateAnnouncement($id, $request->only([
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
        $response = $this->announcementService->removeAnnouncement($id);
        return response($response);
    }
}
