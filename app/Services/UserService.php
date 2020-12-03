<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserService extends Service
{
    protected $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function getAllUsers()
    {
        return $this->userRepo->all();
    }
}
