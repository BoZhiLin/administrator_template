<?php

namespace App\Services;

use App\Defined\ResponseDefined;

use App\Repositories\AnnouncementRepository;

class AnnouncementService extends Service
{
    protected $announcementRepo;

    public function __construct(AnnouncementRepository $announcementRepo)
    {
        $this->announcementRepo = $announcementRepo;
    }

    public function getAnnouncements(bool $with_all = false)
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $response['data']['announcement'] = $this->announcementRepo->getAll($with_all);
        return $response;
    }

    public function getAnnouncement(int $id)
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $announcement = $this->announcementRepo->find($id);

        if (is_null($announcement)) {
            $response['status'] = ResponseDefined::ANNOUNCEMENT_NOT_FOUND;
        } else {
            $response['data']['announcement'] = $announcement;
        }

        return $response;
    }

    public function createAccouncement(array $data)
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $announcement = $this->announcementRepo->create($data);
        $response['data']['announcement'] = $announcement;

        return $response;
    }

    public function updateAnnouncement(int $id, array $data)
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $announcement = $this->announcementRepo->find($id);

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

    public function removeAnnouncement(int $id)
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $announcement = $this->announcementRepo->find($id);

        if (is_null($announcement)) {
            $response['status'] = ResponseDefined::ANNOUNCEMENT_NOT_FOUND;
        } else {
            $announcement->delete();
        }

        return $response;
    }
}
