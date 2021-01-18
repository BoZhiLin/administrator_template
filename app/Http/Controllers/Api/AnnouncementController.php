<?php

namespace App\Http\Controllers\Api;

use App\Services\AnnouncementService;

class AnnouncementController extends ApiController
{
    public function index()
    {
        $response = AnnouncementService::getAnnouncements();
        return response($response);
    }

    public function show(int $announcement_id)
    {
        $response = AnnouncementService::getAnnouncement($announcement_id);
        return response($response);
    }
}
