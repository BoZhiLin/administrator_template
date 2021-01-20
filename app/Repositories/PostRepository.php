<?php

namespace App\Repositories;

class PostRepository extends Repository
{
    public static function index()
    {
        return static::getModel()::with(['user' => function ($query) {
                $query->select('users.id', 'name', 'nickname', 'avatar');
            }, 'favoriteUsers' => function ($query) {
                $query->select('users.id', 'name', 'nickname', 'avatar');
            }])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public static function find(int $id)
    {
        return static::getModel()::where('id', $id)
            ->with(['favoriteUsers' => function ($query) {
                $query->select('users.id', 'name', 'nickname', 'avatar');
            }])
            ->first();
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
