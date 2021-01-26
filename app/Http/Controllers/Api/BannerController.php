<?php

namespace App\Http\Controllers\Api;

use App\Services\BannerService;

class BannerController extends ApiController
{
    protected $bannerService;

    public function __construct(BannerService $bannerService)
    {
        $this->bannerService = $bannerService;
    }

    public function index()
    {
        $response = $this->bannerService->getBanners();
        return response($response);
    }
}
