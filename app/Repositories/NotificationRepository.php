<?php

namespace App\Repositories;

class NotificationRepository extends Repository
{
    public function create(array $data)
    {
        $model = $this->getModel();
        $notification = new $model();
        $notification->user_id = $data['user_id'];
        $notification->title = $data['title'];
        $notification->content = $data['content'];
        $notification->save();
    }

    public function getModel()
    {
        return \App\Models\Notification::class;
    }
}
