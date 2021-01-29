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
     * 後台人員列表 (撇除自己本身)
     * 
     * @param int $self_id (自己的id)
     * @return array
     */
    public function getAdministrators(int $self_id = null)
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $administrators = $this->adminUser->all()
            ->where('id', '<>', $self_id)
            ->map(function ($admin) {
                return [
                    'id' => $admin->id,
                    'name' => $admin->name,
                    'email' => $admin->email,
                    'username' => $admin->username,
                    'last_ip' => $admin->last_ip,
                    'created_at' => strtotime($admin->created_at),
                    'updated_at' => strtotime($admin->updated_at)
                ];
            });
        $response['data']['administrators'] = $administrators;

        return $response;
    }

    /**
     * 創建後台人員
     * 
     * @param array $data
     * @return array
     */
    public function createAdministrator(array $data)
    {
        $response = ['status' => ResponseDefined::SUCCESS];
        $response['data']['administrator'] = $this->adminUser->create($data);
        
        return $response;
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

        if ($response['status'] === ResponseDefined::SUCCESS) {
            $admin_user->save();
        }

        return $response;
    }
}
