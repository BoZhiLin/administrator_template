<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Defined\ResponseDefined;

use App\Services\BannerService;

class BannerController extends AdminController
{
    public function index()
    {
        $response = BannerService::getBanners(true);
        return response($response);
    }

    public function show(int $id)
    {
        $response = BannerService::getBanner($id);
        return response($response);
    }

    public function store(Request $request)
    {
        $response = $this->validateRequest($request->all(), [
            'file' => 'required|file|max:8192',
            'target_url' => 'required|url',
            'sort' => 'numeric',
            'started_at' => 'date_format:Y-m-d H:i:s',
            'ended_at' => 'date_format:Y-m-d H:i:s'
        ]);
        
        if ($response['status'] === ResponseDefined::SUCCESS) {
            $response = BannerService::createBanner($request->only([
                'file',
                'target_url',
                'sort',
                'started_at',
                'ended_at'
            ]));
        }
        
        return response($response);
    }

    public function update(int $id, Request $request)
    {
        $response = $this->validateRequest($request->all(), [
            'file' => 'file|max:8192',
            'target_url' => 'required|url',
            'sort' => 'numeric',
            'started_at' => 'date_format:Y-m-d H:i:s',
            'ended_at' => 'date_format:Y-m-d H:i:s'
        ]);
        
        if ($response['status'] === ResponseDefined::SUCCESS) {
            $response = BannerService::updateBanner($id, $request->only([
                'file',
                'target_url',
                'sort',
                'started_at',
                'ended_at'
            ]));
        }

        return response($response);
    }

    public function destroy($id)
    {
        $response = BannerService::removeBanner($id);
        return response($response);
    }
}
