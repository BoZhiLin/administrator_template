<?php

namespace App\Repositories;

use App\Models\Config;

class ConfigRepository extends Repository
{
    public function getByType(string $type)
    {
        return $this->getModel()
            ->where('type', $type)
            ->first();
    }

    public function getModel()
    {
        return (Config::class)::on($this->connection);
    }
}
