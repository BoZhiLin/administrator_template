<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Hash;

use App\Tools\Tool;

class UserRepository extends Repository
{
    /**
     * 新增/註冊會員
     */
    public static function create(array $data)
    {
        $model = static::getModel();
        $user = new $model();
        $user->gender = $data['gender'];
        $user->name = $data['name'];
        $user->birthday = $data['birthday'];
        $user->nickname = $data['nickname'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->constellation = Tool::getConstellation($data['birthday']);
        $user->age = Tool::getAge($data['birthday']);
        $user->save();

        return $user;
    }

    /**
     * 更新個人資料
     */
    public static function update(int $id, array $data)
    {
        $user = static::getModel()::find($id);
        
        foreach ($data as $attribute => $value) {
            $user->$attribute = $value;
        }

        $user->save();
        return $user;
    }

    /**
     * 通過認證
     */
    public static function setVerified(int $id)
    {
        $now = now();
        $user = static::getModel()::find($id);
        $user->email_verified_at = $now;
        $user->is_verified = true;
        $user->save();
    }

    public static function getByEmail(string $email)
    {
        return static::getModel()::where('email', $email)->first();
    }

    public static function getModel()
    {
        return \App\Models\User::class;
    }
}
