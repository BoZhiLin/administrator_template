<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;

use App\Defined\ResponseDefined;

use App\Repositories\AdminUserRepository;

class AdminService extends Service
{
    protected $adminUser;

    public function __construct(AdminUserRepository $adminUser)
    {
        $this->adminUser = $adminUser;
    }

    /**
     * 取得後台當前人員資訊
     * 
     * @param int $admin_id
     * @return array
     */
    public function getInfo(int $admin_id)
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $admin_user = $this->adminUser->find($admin_id);

        if (is_null($admin_user)) {
            $response['status'] = ResponseDefined::ADMIN_NOT_FOUND;
        } else {
            $admin_user = $admin_user->toArray();
            $admin_user['created_at'] = strtotime($admin_user['created_at']);
            $admin_user['updated_at'] = strtotime($admin_user['updated_at']);
            $response['data']['admin'] = $admin_user;
        }

        return $response;
    }

    /**
     * 修改後台當前人員資訊 (含修改密碼)
     * 
     * @param int $admin_id
     * @param array $data
     * @return array
     */
    public function setInfo(int $admin_id, array $data)
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $admin_user = $this->adminUser->find($admin_id);
        $admin_user->name = $data['name'];

        if (isset($data['email'])) {
            $admin_user->email = $data['email'];
        }

        if (isset($data['old_password']) && isset($data['new_password'])) {
            if (!password_verify($data['old_password'], $admin_user->password)) {
                $response['status'] = ResponseDefined::OLD_PASSWORD_VERIFY_FAIL;
            } else {
                $admin_user->password = Hash::make($data['new_password']);
            }
        }

        $admin_user->save();
        return $response;
    }
}
