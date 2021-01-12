<?php

namespace App\Services;

use App\Defined\ResponseDefined;

use App\Repositories\AnnouncementRepository;

class AnnouncementService extends Service
{
    public static function getAnnouncements(bool $with_all = false)
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $response['data']['announcement'] = AnnouncementRepository::getAll($with_all);
        return $response;
    }

    public static function getAnnouncement(int $id)
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $announcement = AnnouncementRepository::find($id);

        if (is_null($announcement)) {
            $response['status'] = ResponseDefined::ANNOUNCEMENT_NOT_FOUND;
        } else {
            $response['data']['announcement'] = $announcement;
        }

        return $response;
    }

    public static function createAccouncement(array $data)
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $announcement = AnnouncementRepository::create($data);
        $response['data']['announcement'] = $announcement;

        return $response;
    }

    public static function updateAnnouncement(int $id, array $data)
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $announcement = AnnouncementRepository::find($id);

        if (is_null($announcement)) {
            $response['status'] = ResponseDefined::ANNOUNCEMENT_NOT_FOUND;
        } else {
            $announcement->title = $data['title'];
            $announcement->content = $data['content'];

            if (isset($data['started_at'])) {
                $announcement->started_at = $data['started_at'];
            }
            if (isset($data['ended_at'])) {
                $announcement->ended_at = $data['ended_at'];
            }

            $announcement->save();
        }

        return $response;
    }

    public static function removeAnnouncement(int $id)
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $announcement = AnnouncementRepository::find($id);

        if (is_null($announcement)) {
            $response['status'] = ResponseDefined::ANNOUNCEMENT_NOT_FOUND;
        } else {
            $announcement->delete();
        }

        return $response;
    }
}
