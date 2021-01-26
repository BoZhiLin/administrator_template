<?php

namespace App\Http\Controllers\Api;

use App\Services\AnnouncementService;

class AnnouncementController extends ApiController
{
    protected $announcementService;

    public function __construct(AnnouncementService $announcementService)
    {
        $this->announcementService = $announcementService;
    }

    public function index()
    {
        $response = $this->announcementService->getAnnouncements();
        return response($response);
    }

    public function show(int $announcement_id)
    {
        $response = $this->announcementService->getAnnouncement($announcement_id);
        return response($response);
    }
}
