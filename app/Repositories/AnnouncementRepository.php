<?php

namespace App\Repositories;

class AnnouncementRepository extends Repository
{
    public function getAll(bool $with_all = false)
    {
        $now = now();
        $eloquent = $this->getModel()::orderBy('created_at', 'desc');

        if ($with_all === false) {
            $eloquent->where(function ($query) use ($now) {
                $query->where('started_at', '<=', $now)
                    ->where('ended_at', '>=', $now);
            })->orWhere(function ($query) use ($now) {
                $query->where('started_at', '<=', $now)
                    ->whereNull('ended_at');
            });
        }

        return $eloquent->get();
    }

    public function create(array $data)
    {
        $model = $this->getModel();
        $announcement = new $model();
        $announcement->title = $data['title'];
        $announcement->content = $data['content'];

        if (isset($data['started_at'])) {
            $announcement->started_at = $data['started_at'];
        }
        if (isset($data['ended_at'])) {
            $announcement->ended_at = $data['ended_at'];
        }

        $announcement->save();
        return $announcement;
    }

    public function getModel()
    {
        return \App\Models\Announcement::class;
    }
}
