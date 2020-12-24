<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Defined\ResponseDefined;

use App\Services\PostService;

class PostController extends ApiController
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function store(Request $request)
    {
        $response = $this->validateRequest($request->all(), [
            'content' => 'required|string|max:255'
        ]);

        if ($response['status'] === ResponseDefined::SUCCESS) {
            $request_parameters = $request->only(['content']);
            $request_parameters['user_id'] = auth('api')->id();
            $response = $this->postService->create($request_parameters);
        }

        return $response;
    }
}
