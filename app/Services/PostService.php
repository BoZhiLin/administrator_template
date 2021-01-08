<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

use App\Defined\ResponseDefined;

use App\Repositories\PostRepository;

class PostService extends Service
{
    public static function create(array $data)
    {
        $response = ['status' => ResponseDefined::SUCCESS];

        if (isset($data['images'])) {
            // TODO 上傳圖片待規劃
        }

        $response['data']['post'] = PostRepository::create($data);
        return $response;
    }
}
