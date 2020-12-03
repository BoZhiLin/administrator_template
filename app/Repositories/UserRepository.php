<?php

namespace App\Repositories;

class UserRepository extends Repository
{
    public function getModel()
    {
        return (\App\Models\User::class)::on($this->connection);
    }
}
