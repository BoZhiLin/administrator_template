<?php

namespace App\Repositories;

use App\Repositories\Interfaces\Eloquent;

abstract class Repository implements Eloquent
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function all()
    {
        return static::getModel()::get();
    }

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function find(int $id)
    {
        return static::getModel()::find($id);
    }

    /**
     * @param int $id
     * @return bool
     */
    public static function delete(int $id)
    {
        return static::getModel()::destroy($id);
    }
    
    abstract public static function getModel();
}
