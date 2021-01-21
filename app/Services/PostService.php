<?php

namespace App\Services;

use Latrell\Lock\Facades\Lock;

use Illuminate\Support\Facades\Storage;

use App\Defined\ResponseDefined;

use App\Models\User;

use App\Repositories\PostRepository;

class PostService extends Service
{
    public static function getPosts()
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $posts = PostRepository::index();
        $response['data']['posts'] = $posts;

        return $response;
    }

    public static function getPostByID(int $post_id)
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $post = PostRepository::find($post_id);

        if (is_null($post)) {
            $response['status'] = ResponseDefined::POST_NOT_FOUND;
        } else {
            $response['data']['post'] = $post;
        }

        return $response;
    }

    public static function create(array $data)
    {
        $response = ['status' => ResponseDefined::SUCCESS];

        if (isset($data['images'])) {
            // TODO 上傳圖片待規劃
        }

        $response['data']['post'] = PostRepository::create($data);
        return $response;
    }

    /**
     * 按讚
     */
    public static function likeByUser(User $user, int $post_id)
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $post = PostRepository::find($post_id);

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
     */
    public static function cancelLikeByUser(User $user, int $post_id)
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $post = PostRepository::find($post_id);

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
