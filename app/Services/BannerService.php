<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

use App\Defined\ResponseDefined;

use App\Repositories\BannerRepository;

class BannerService extends Service
{
    public static function getBanners(bool $with_all = false)
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $response['data']['banner'] = BannerRepository::getAll($with_all);
        return $response;
    }

    public static function getBanner(int $id)
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $banner = BannerRepository::find($id);

        if (is_null($banner)) {
            $response['status'] = ResponseDefined::Banner_NOT_FOUND;
        } else {
            $response['data']['banner'] = $banner;
        }

        return $response;
    }

    public static function createBanner(array $data)
    {
        $response = ['status' => ResponseDefined::SUCCESS];

        $new_banner_path = 'banner/'.$data['file']->getClientOriginalName();
        Storage::disk('public')->put($new_banner_path, file_get_contents($data['file']->getRealPath()));
        $data['path'] = $new_banner_path;

        $banner = BannerRepository::create($data);

        $response['data']['banner'] = $banner;

        return $response;
    }
    
    public static function updateBanner(int $id, array $data)
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $banner = bannerRepository::find($id);

        if (is_null($banner)) {
            $response['status'] = ResponseDefined::Banner_NOT_FOUND;
        } else {
            if (isset($data['file'])) {
                $new_banner_path = 'banner/'.$data['file']->getClientOriginalName();
                Storage::disk('public')->delete(''. $banner->path);
                Storage::disk('public')->put($new_banner_path, file_get_contents($data['file']->getRealPath()));
                $banner->path = $new_banner_path;
            }  
              
            if (isset($data['target_url'])) {
                $banner->target_url = $data['target_url'];
            }
            if (isset($data['started_at'])) {
                $banner->started_at = $data['started_at'];
            }
            if (isset($data['ended_at'])) {
                $banner->ended_at = $data['ended_at'];
            }

            $banner->save();
        }

        return $response;
    }

    public static function removeBanner(int $id)
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $banner = bannerRepository::find($id);

        if (is_null($banner)) {
            $response['status'] = ResponseDefined::Banner_NOT_FOUND;
        } else {
            Storage::disk('public')->delete($banner->path);
            $banner->delete();
        }

        return $response;
    }
}
