<?php

namespace App\Http\Controllers\Api;

use App\Services\BannerService;

class BannerController extends ApiController
{
    public function index()
    {
        $response = BannerService::getBanners();
        return response($response);
    }
}
