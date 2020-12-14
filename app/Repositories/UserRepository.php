<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Hash;

use App\Models\User;

class UserRepository extends Repository
{
    /**
     * 新增/註冊會員
     * 
     * @param array $data
     * @return User
     */
    public function create(array $data)
    {
        $user = new User();
        $user->name = $data['name'];
        $user->nickname = $data['nickname'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);

        if (isset($user->avatar)) {
            $user->avatar = $data['avatar'];
        }
        
        if (isset($data['phone'])) {
            $user->phone = $data['phone'];
        }

        $user->save();
        return $user;
    }

    public function getModel()
    {
        return (User::class)::on($this->connection);
    }
}
