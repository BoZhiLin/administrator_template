<?php

namespace App\Repositories;

class TagRepository extends Repository
{
    public function setByUser(int $user_id, string $type)
    {
        $this->getModel()::firstOrCreate([
            'user_id' => $user_id,
            'type' => $type
        ]);
    }

    public function getByUser(int $user_id, string $type)
    {
        return $this->getModel()::where('user_id', $user_id)
            ->where('type', $type)
            ->first();
    }

    public function removeByUser(int $user_id, string $type)
    {
        $this->getModel()::where('user_id', $user_id)
            ->where('type', $type)
            ->delete();
    }

    public function getModel()
    {
        return \App\Models\Tag::class;
    }
}
