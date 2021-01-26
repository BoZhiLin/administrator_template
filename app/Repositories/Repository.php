<?php

namespace App\Repositories;

use App\Repositories\Interfaces\Eloquent;

abstract class Repository implements Eloquent
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return $this->getModel()::get();
    }

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function find(int $id)
    {
        return $this->getModel()::find($id);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id)
    {
        return $this->getModel()::destroy($id);
    }
    
    abstract public function getModel();
}
