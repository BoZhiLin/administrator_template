<?php

namespace App\Services;

use Latrell\Lock\Facades\Lock;

use Illuminate\Support\Facades\Storage;

use App\Defined\ResponseDefined;

use App\Models\User;

use App\Repositories\PostRepository;

class PostService extends Service
{
    protected $postRepo;

    public function __construct(PostRepository $postRepo)
    {
        $this->postRepo = $postRepo;
    }
    /**
     * 文章清單
     * 
     * @return array
     */
    public function getPosts()
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $posts = $this->postRepo->index();
        $response['data']['posts'] = $posts;

        return $response;
    }

    /**
     * 特定文章
     * 
     * @param int $post_id
     * @return array
     */
    public function getPostByID(int $post_id)
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $post = $this->postRepo->find($post_id);

        if (is_null($post)) {
            $response['status'] = ResponseDefined::POST_NOT_FOUND;
        } else {
            $response['data']['post'] = $post;
        }

        return $response;
    }

    /**
     * PO文
     * 
     * @param array $data
     * @return array
     */
    public function create(array $data)
    {
        $response = ['status' => ResponseDefined::SUCCESS];

        if (isset($data['images'])) {
            // TODO 上傳圖片待規劃
        }

        $response['data']['post'] = $this->postRepo->create($data);
        return $response;
    }

    /**
     * 按讚
     * 
     * @param User $user
     * @param int $post_id
     * @return array
     */
    public function likeByUser(User $user, int $post_id)
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $post = $this->postRepo->find($post_id);

        if (is_null($post)) {
            $response['status'] = ResponseDefined::POST_NOT_FOUND;
        } elseif (!is_null($post->favoriteUsers->firstWhere('id', $user->id))) {
            $response['status'] = ResponseDefined::POST_HAS_LIKE;
        } else {
            $lock_key = "like@post_$post_id";

            try {
                Lock::acquire($lock_key);
                $user->favoritePosts()->attach($post_id);
                $post->increment('like_amount');
                $response['data']['post'] = $post;
            } finally {
                Lock::release($lock_key);
            }
        }

        return $response;
    }

    /**
     * 取消讚
     * 
     * @param User $user
     * @param int $post_id
     * @return array
     */
    public function cancelLikeByUser(User $user, int $post_id)
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $post = $this->postRepo->find($post_id);

        if (is_null($post)) {
            $response['status'] = ResponseDefined::POST_NOT_FOUND;
        } elseif (is_null($post->favoriteUsers->firstWhere('id', $user->id))) {
            $response['status'] = ResponseDefined::POST_NOT_LIKE;
        } else {
            $lock_key = "cancel@post_$post_id";

            try {
                Lock::acquire($lock_key);
                $user->favoritePosts()->detach($post_id);
                $post->decrement('like_amount');
                $response['data']['post'] = $post;
            } finally {
                Lock::release($lock_key);
            }
        }

        return $response;
    }
}
