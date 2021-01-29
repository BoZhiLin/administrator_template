<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Hash;

class AdminUserRepository extends Repository
{
    public function create(array $data)
    {
        $model = $this->getModel();
        $admin_user = new $model();
        $admin_user->name = $data['name'];

        if (isset($data['email'])) {
            $admin_user->email = $data['email'];
        }

        $admin_user->username = $data['username'];
        $admin_user->password = Hash::make($data['password']);
        $admin_user->save();

        return $admin_user;
    }

    public function getModel()
    {
        return \App\Models\AdminUser::class;
    }
}
