<?php

namespace App\Repositories;

class PostRepository extends Repository
{
    public static function search(array $condition = [])
    {
        return 
            static::getModel()::when($condition['user_id'], function ($query) use ($condition) {
                $query->where('user_id', $condition['user_id']);
            })
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public static function find(int $id)
    {
        return static::getModel()::find($id)->load('favoriteUsers');
    }

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
