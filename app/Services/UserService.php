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
use App\Defined\OrderTypeDefined;
use App\Defined\OrderStatusDefined;

use App\Repositories\VipRepository;
use App\Repositories\UserRepository;
use App\Repositories\OrderRepository;
use App\Repositories\UserMatchRepository;

class UserService extends Service
{
    /**
     * 註冊
     * 
     * @param array $data
     * @return array
     */
    public static function register(array $data)
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $user = UserRepository::create($data);
        $response['data']['user'] = $user;

        return $response;
    }

    /**
     * 產生驗證碼並且寄Email
     * 
     * @param User $user
     * @return array
     */
    public static function sendVerifyCode(User $user)
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $verify_code = random_int(100000, 999999);
        $key = "verify@user:$user->id";
        $expire_seconds = SystemDefined::VERIFY_CODE_EXPIRED * 60;
        Cache::put($key, $verify_code, $expire_seconds);
        SendVerifyMail::dispatch($user, $verify_code);

        return $response;
    }

    /**
     * 驗證使用者信箱，驗證成功則贈送3天黃金會員
     * 
     * @param User $user
     * @param mixed $code
     * @return array
     */
    public static function verifyUser(User $user, $code = null)
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $key = "verify@user:$user->id";
        $verify_code = Cache::get($key);

        if (!$code) {
            $response['status'] = ResponseDefined::VERIFY_CODE_REQUIRED;
        } elseif (!$verify_code) {
            $response['status'] = ResponseDefined::VERIFY_CODE_EXPIRED;
        } elseif ($code != $verify_code) {
            $response['status'] = ResponseDefined::VERIFY_CODE_ERROR;
        } else {
            $user->email_verified_at = now();
            $user->is_verified = true;
            $user->save();

            VipRepository::buyByUser($user->id, VipTypeDefined::GOLD, SystemDefined::USER_DEFAULT_DAYS);
            Cache::forget($key);
        }

        return $response;
    }

    /**
     * 忘記密碼
     * 
     * @param string $email
     * @return array
     */
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

    /**
     * 重設密碼
     * 
     * @param int $user_id
     * @param string $password
     * @return array
     */
    public static function resetPassword(int $user_id, string $password)
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $user = UserRepository::find($user_id);
        $user->password = Hash::make($password);
        $user->save();

        return $response;
    }

    /**
     * 取得使用者資料
     * 
     * @param int $user_id
     * @return array
     */
    public static function getInfo(int $user_id)
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $response['data']['user'] = static::getUserInfo($user_id);
        return $response;
    }

    /**
     * 設定使用者資料
     * 
     * @param int $user_id
     * @param array $data
     * @return array
     */
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

    /**
     * 發送配對邀請 or 接受配對邀請 (按LIKE，互相按LIKE則自動配對)
     * 
     * @param int $from_id
     * @param int $match_id
     * @return array
     */
    public static function match(int $from_id, int $match_id)
    {
        $response = ['status' => ResponseDefined::SUCCESS];

        if (!UserRepository::find($match_id)) {
            $response['status'] = ResponseDefined::USER_NOT_FOUND;
        } elseif ($from_id === $match_id) {
            $response['status'] = ResponseDefined::NOT_ALLOW_SEND_SELF;
        } elseif (
            ($match_info = UserMatchRepository::getByBothUser($from_id, $match_id)) &&
            $match_info->is_matched
        ) {
            $response['status'] = ResponseDefined::USER_HAS_MATCHED;
        } elseif (
            ($match_info = UserMatchRepository::getByBothUser($from_id, $match_id)) &&
            $match_info->from_id === $from_id
        ) {
            $response['status'] = ResponseDefined::MATCH_HAS_SEND;
        } else {
            $match_info = UserMatchRepository::sendOrMatch([
                'from_id' => $from_id,
                'match_id' => $match_id
            ]);

            if ($match_info->is_matched) {
                /** TODO: 通知兩人已成功配對 */
            } else {
                /** TODO: 通知對方有配對邀請 */
            }
        }
        /** 不可重複配對，亦不可重複發送邀請 */
         

        return $response;
    }

    /**
     * 解除配對 or 對方拒絕配對邀請
     * 
     * @param int $from_id
     * @param int $target_id (配對對象 or 欲拒絕對象)
     * @return array
     */
    public static function removeMatch(int $from_id, int $target_id)
    {
        $response = ['status' => ResponseDefined::SUCCESS];

        if (!UserRepository::find($target_id)) {
            $response['status'] = ResponseDefined::USER_NOT_FOUND;
        } elseif ($from_id === $target_id) {
            $response['status'] = ResponseDefined::NOT_ALLOW_REMOVE_SELF;
        } elseif (! $match_info = UserMatchRepository::getByBothUser($from_id, $target_id)) {
            $response['status'] = ResponseDefined::MATCH_NOT_FOUND;
        } else {
            $match_info->forceDelete();
        }

        return $response;
    }

    /**
     * 購買VIP資格
     * 
     * @param User $user
     * @return array
     */
    public static function buyVIP(User $user)
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $order_info = [
            'user_id' => $user->id,
            'type' => OrderTypeDefined::BUY_GOLD_VIP,
            'amount' => 1,
            'value' => SystemDefined::GOLD_VIP_PRICE,
            'status' => OrderStatusDefined::PAYING
        ];

        $order = OrderRepository::create($order_info);
        VipRepository::buyByUser($user->id, VipTypeDefined::GOLD, SystemDefined::VIP_EXPIRES_DAYS);
        /** 串金流 TODO */

        return $response;
    }

    /**
     * 完成付款 (留著以後金流webhook用)
     */
    public static function completed()
    {
        // $response = ['status' => ResponseDefined::SUCCESS];
        // VipRepository::buyByUser($user_id, $type, SystemDefined::VIP_EXPIRES_DAYS);
    }

    /**
     * 回傳user陣列 (私有方法)
     * 
     * @param int $user_id
     * @return array
     */
    private static function getUserInfo(int $user_id)
    {
        $user = UserRepository::find($user_id);
        $vip_type = UserRepository::getVipLevel($user);
        $like_posts = $user->favoritePosts->pluck('id');
        
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
            'vip_type' => $vip_type,
            'is_verified' => $user->is_verified,
            'like_posts' => $like_posts
        ];
    }
}
