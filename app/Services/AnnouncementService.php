<?php

namespace App\Services;

use App\Repositories\AnnouncementRepository;
use App\Defined\ResponseDefined;

class AnnouncementService extends Service
{
    public static function all()
    {
        $response = ['status' => ResponseDefined::SUCCESS];

        $response['data']['announcement'] = AnnouncementRepository::all();
        return $response;
    }

    public static function create(array $data)
    {
        $response = ['status' => ResponseDefined::SUCCESS];

        $response['data']['announcement'] = AnnouncementRepository::create($data);
        return $response;
    }

    public static function find(int $id)
    {
        return AnnouncementRepository::find($id);
    }

}