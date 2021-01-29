<?php

namespace App\Repositories;

class AdminUserRepository extends Repository
{
    public function getModel()
    {
        return \App\Models\AdminUser::class;
    }
}
