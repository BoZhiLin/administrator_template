<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

use App\Jobs\SendVerifyMail;
use App\Jobs\SendForgotMail;

use App\Models\User;

use App\Defined\SystemDefined;
use App\Defined\VipTypeDefined;
use App\Defined\ResponseDefined;

use App\Repositories\UserRepository;
use App\Repositories\VipRepository;

class UserService extends Service
{
    public static function register(array $data)
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $user = UserRepository::create($data);
        static::generateVerifyCode($user);

        return $response;
    }

    public static function verifyUser(int $user_id, $code = null)
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $key = "verify@user:$user_id";
        $verify_code = Cache::get($key);

        if (!$code) {
            $response['status'] = ResponseDefined::VERIFY_CODE_REQUIRED;
        } elseif (!$verify_code) {
            $response['status'] = ResponseDefined::VERIFY_CODE_EXPIRED;
        } elseif ($code != $verify_code) {
            $response['status'] = ResponseDefined::VERIFY_CODE_ERROR;
        } else {
            /** 驗證成功，贈送3天一般會員身分 */
            UserRepository::setVerified($user_id);
            VipRepository::buyByUser($user_id, VipTypeDefined::GENERAL, SystemDefined::USER_DEFAULT_DAYS);
            Cache::forget($key);
        }

        return $response;
    }

    public static function sendVerifyCode(int $user_id)
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $user = UserRepository::find($user_id);
        static::generateVerifyCode($user);

        return $response;
    }

    public static function forgetPassword(string $email)
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $user = UserRepository::getByEmail($email);

        if (is_null($user)) {
            $response['status'] = ResponseDefined::USER_NOT_FOUND;
        } else {
            $new_password = Str::random(10);
            $user->password = Hash::make($new_password);
            $user->save();
            SendForgotMail::dispatch($user, ['password' => $new_password]);
        }

        return $response;
    }

    public static function resetPassword(int $user_id, string $password)
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $user = UserRepository::find($user_id);
        $user->password = Hash::make($password);
        $user->save();

        return $response;
    }

    public static function setInfo(int $user_id, array $data)
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        
        if (isset($data['avatar'])) {
            $new_avatar_path = 'avatar/' . $user_id . '.' . $data['avatar']->guessClientExtension();
            Storage::disk('public')->delete('avatar/' . $user_id);
            Storage::disk('public')->put($new_avatar_path, file_get_contents($data['avatar']->getRealPath()));
            $data['avatar'] = $new_avatar_path;
        }

        $user = UserRepository::update($user_id, $data);
        $response['data']['user'] = static::getUserInfo($user->id);

        return $response;
    }

    public static function getInfo(int $user_id)
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $response['data']['user'] = static::getUserInfo($user_id);

        return $response;
    }

    private static function getUserInfo(int $user_id)
    {
        $user = UserRepository::find($user_id);
        $vip_levels = VipRepository::getLevelsByUser($user_id);
        
        return [
            'id' => $user->id,
            'gender' => $user->gender,
            'name' => $user->name,
            'nickname' => $user->nickname,
            'email' => $user->email,
            'avatar' => $user->avatar,
            'phone' => $user->phone,
            'introduction' => $user->introduction,
            'blood' => $user->blood,
            'constellation' => $user->constellation,
            'is_verified' => $user->is_verified,
            'gold_expired_at' => $vip_levels['gold_expired_at'],
            'general_expired_at' => $vip_levels['general_expired_at']
        ];
    }

    private static function generateVerifyCode(User $user)
    {
        $verify_code = random_int(100000, 999999);
        $key = 'verify@user:' . $user->id;
        $expire_seconds = SystemDefined::VERIFY_CODE_EXPIRED * 60;
        Cache::put($key, $verify_code, $expire_seconds);
        SendVerifyMail::dispatch($user, $verify_code);
    }
}
