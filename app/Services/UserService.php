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
use App\Defined\ConfigDefined;
use App\Defined\ResponseDefined;

use App\Repositories\UserRepository;
use App\Repositories\ConfigRepository;

class UserService extends Service
{
    protected $userRepo;
    protected $configRepo;

    public function __construct(UserRepository $userRepo, ConfigRepository $configRepo)
    {
        $this->userRepo = $userRepo;
        $this->configRepo = $configRepo;
    }

    /**
     * 前台註冊會員
     * 
     * @param array $data
     * @return array
     */
    public function register(array $data)
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $user = $this->userRepo->create($data);
        $this->generateVerifyCode($user);

        return $response;
    }

    /**
     * 註記已認證的會員
     */
    public function verifyUser(int $user_id, $code = null)
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
            $expire_days = $this->configRepo->getByType(ConfigDefined::DEFAULT_EXPIRED_IN)->value;
            $this->userRepo->setVerified($user_id, $expire_days);
            Cache::forget($key);
        }

        return $response;
    }

    /**
     * 寄驗證碼
     */
    public function sendVerifyCode(int $user_id)
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $user = $this->userRepo->find($user_id);
        $this->generateVerifyCode($user);

        return $response;
    }

    public function forgetPassword(string $email)
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $user = $this->userRepo->getByEmail($email);

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

    public function resetPassword(int $user_id, string $password)
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $user = $this->userRepo->find($user_id);
        $user->password = Hash::make($password);
        $user->save();

        return $response;
    }

    /**
     * 取得登入會員資訊
     * 
     * @return array
     */
    public function getInfo()
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $user = auth('api')->user();

        if (is_null($user)) {
            $response['status'] = ResponseDefined::USER_NOT_FOUND;
        } else {
            $response['data']['user'] = [
                'id' => $user->id,
                'name' => $user->name,
                'nickname' => $user->nickname,
                'email' => $user->email,
                'avatar' => $user->avatar,
                'phone' => $user->phone,
                'expired_at' => $user->expired_at
            ];
        }

        return $response;
    }

    /**
     * 產生驗證碼與發送信件
     * 
     * @param User $user
     * @return void
     */
    private function generateVerifyCode(User $user)
    {
        $verify_code = random_int(100000, 999999);
        $key = 'verify@user:' . $user->id;
        $expire_seconds = SystemDefined::VERIFY_CODE_EXPIRED * 60;
        Cache::put($key, $verify_code, $expire_seconds);
        SendVerifyMail::dispatch($user, $verify_code);
    }
}
