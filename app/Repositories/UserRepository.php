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
        $user->phone = $data['phone'];
        
        if (isset($user->avatar)) {
            $user->avatar = $data['avatar'];
        }

        $user->save();
        return $user;
    }

    /**
     * 認證註記
     * 
     * @param int $id (使用者ID)
     * @param int $expires (試用會員有效天數)
     * @return void
     */
    public function setVerified(int $id, int $expires)
    {
        $now = now();
        $user = $this->getModel()->find($id);
        $user->email_verified_at = $now;
        $user->expired_at = $now->addDays($expires);
        $user->is_verified = true;
        $user->save();
    }

    public function getByEmail(string $email)
    {
        return $this->getModel()
            ->where('email', $email)
            ->first();
    }

    public function getModel()
    {
        return (User::class)::on($this->connection);
    }
}
