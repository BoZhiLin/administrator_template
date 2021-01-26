<?php

namespace App\Repositories;

class PostRepository extends Repository
{
    public function index()
    {
        return $this->getModel()::with(['user' => function ($query) {
                $query->select('users.id', 'name', 'nickname', 'avatar');
            }, 'favoriteUsers' => function ($query) {
                $query->select('users.id', 'name', 'nickname', 'avatar');
            }])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function find(int $id)
    {
        return $this->getModel()::where('id', $id)
            ->with(['favoriteUsers' => function ($query) {
                $query->select('users.id', 'name', 'nickname', 'avatar');
            }])
            ->first();
    }

    public function create(array $data)
    {
        $model = $this->getModel();
        $post = new $model();
        $post->user_id = $data['user_id'];
        $post->content = $data['content'];
        $post->save();

        return $post;
    }

    public function getModel()
    {
        return \App\Models\Post::class;
    }
}
