<?php

namespace App\Repositories;

class PostRepository extends Repository
{
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
