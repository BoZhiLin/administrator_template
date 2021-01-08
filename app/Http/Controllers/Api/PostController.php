<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Defined\ResponseDefined;

use App\Services\PostService;

class PostController extends ApiController
{
    public function store(Request $request)
    {
        $response = $this->validateRequest($request->all(), [
            'content' => 'required|string|max:255'
        ]);

        if ($response['status'] === ResponseDefined::SUCCESS) {
            $request_parameters = $request->only(['content']);
            $request_parameters['user_id'] = auth('api')->id();
            $response = PostService::create($request_parameters);
        }

        return $response;
    }

    public function like(int $post_id)
    {
        $user = auth()->user();
        $response = PostService::likeByUser($user, $post_id);
        return $response;
    }

    public function dislike(int $post_id)
    {
        $user = auth()->user();
        $response = PostService::cancelLikeByUser($user, $post_id);
        return $response;
    }
}
