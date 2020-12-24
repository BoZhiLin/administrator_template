<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

use App\Defined\ResponseDefined;

use App\Repositories\PostRepository as PostRepo;

class PostService extends Service
{
    protected $postRepo;

    public function __construct(PostRepo $postRepo)
    {
        $this->postRepo = $postRepo;
    }

    public function create(array $data)
    {
        $response = ['status' => ResponseDefined::SUCCESS];

        if (isset($data['images'])) {
            // TODO 上傳圖片待規劃
        }

        $response['data']['post'] = $this->postRepo->create($data);
        return $response;
    }
}
