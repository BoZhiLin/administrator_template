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

    public function index()
    {
        $response = $this->postService->getPosts();
        return response($response);
    }

    public function show(int $post_id)
    {
        $response = $this->postService->getPostByID($post_id);
        return response($response);
    }

    public function store(Request $request)
    {
        $response = $this->validateRequest($request->all(), [
            'content' => 'required|string|max:255'
        ]);

        if ($response['status'] === ResponseDefined::SUCCESS) {
            $request_parameters = $request->only(['content']);
            $request_parameters['user_id'] = auth()->id();
            $response = $this->postService->create($request_parameters);
        }

        return response($response);
    }

    public function like(int $post_id)
    {
        $response = $this->postService->likeByUser(auth()->user(), $post_id);
        return response($response);
    }

    public function dislike(int $post_id)
    {
        $response = $this->postService->cancelLikeByUser(auth()->user(), $post_id);
        return response($response);
    }
}
