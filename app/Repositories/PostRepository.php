<?php

namespace App\Repositories;

class PostRepository extends Repository
{
    public static function create(array $data)
    {
        $model = static::getModel();
        $post = new $model();
        $post->user_id = $data['user_id'];
        $post->content = $data['content'];
        $post->save();

        return $post;
    }

    public static function getModel()
    {
        return \App\Models\Post::class;
    }
}
