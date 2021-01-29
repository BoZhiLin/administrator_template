<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Defined\ResponseDefined;

use App\Services\AdminService;

class AdminUserController extends AdminController
{
    protected $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function getInfo()
    {
        $response = $this->adminService->getInfo(auth('admin')->id());
        return response($response);
    }

    public function setInfo(Request $request)
    {
        $response = $this->validateRequest($request->all(), [
            'name' => 'required',
            'email' => 'nullable|email',
            'old_password' => 'required_with:new_password',
            'new_password' => 'required_with:old_password|min:8|confirmed'
        ], [
            'name' => [
                'Required' => ResponseDefined::NAME_REQUIRED
            ],
            'email' => [
                'Email' => ResponseDefined::EMAIL_INVALID
            ],
            'old_password' => [
                'RequiredWith' => ResponseDefined::OLD_PASSWORD_REQUIRED
            ],
            'new_password' => [
                'RequiredWith' => ResponseDefined::NEW_PASSWORD_REQUIRED,
                'Min' => ResponseDefined::PASSWORD_MIN,
                'Confirmed' => ResponseDefined::NEW_PASSWORD_NOT_MATCH
            ]
        ]);

        if ($response['status'] === ResponseDefined::SUCCESS) {
            $admin_id = auth('admin')->id();
            $response = $this->adminService->setInfo($admin_id, $request->only([
                'name',
                'email',
                'old_password',
                'new_password'
            ]));
        }

        return response($response);
    }
}
