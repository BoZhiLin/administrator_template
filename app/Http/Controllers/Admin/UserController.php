<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Services\UserService;

class UserController extends AdminController
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $users = $this->userService->getAllUsers();
        return $users;
    }

    public function show($id)
    {
        $user = $this->userService->getUser($id);
        return $user;
    }
}
