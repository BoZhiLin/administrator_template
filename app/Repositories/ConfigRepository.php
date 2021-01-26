<?php

namespace App\Repositories;

class ConfigRepository extends Repository
{
    public function getByType(string $type)
    {
        return $this->getModel()::where('type', $type)->first();
    }

    public function getModel()
    {
        return \App\Models\Config::class;
    }
}
