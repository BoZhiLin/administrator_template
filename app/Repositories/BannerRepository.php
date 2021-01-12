<?php

namespace App\Repositories;

class BannerRepository extends Repository
{
    public static function getModel()
    {
        return \App\Models\Banners::class;
    }
}
