<?php

namespace App\Repositories;

use Exception;

use App\Repositories\Interfaces\Eloquent;

abstract class Repository implements Eloquent
{
    protected $connection = 'mysql';

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return $this->getModel()->get();
    }

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function find(int $id)
    {
        return $this->getModel()->find($id);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id)
    {
        return $this->getModel()->destroy($id);
    }

    public function setConnection($db_connection = 'mysql')
    {
        $connection_configs = array_keys(config('database.connections'));

        if (!in_array($db_connection, $connection_configs)) {
            throw new Exception('Connection does not exists.');
        }
        
        $this->connection = $db_connection;
        return $this;
    }
    
    abstract public function getModel();
}
