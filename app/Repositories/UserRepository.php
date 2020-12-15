<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Hash;

use App\Models\User;

class UserRepository extends Repository
{
    /**
     * 新增/註冊會員
     */
    public function create(array $data)
    {
        $user = new User();
        $user->gender = $data['gender'];
        $user->name = $data['name'];
        $user->nickname = $data['nickname'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->save();

        return $user;
    }

    /**
     * 更新個人資料
     */
    public function update(int $id, array $data)
    {
        $user = $this->getModel()->find($id);
        
        foreach ($data as $attribute => $value) {
            $user->$attribute = $value;
        }

        $user->save();
        return $user;
    }

    /**
     * 認證註記
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
