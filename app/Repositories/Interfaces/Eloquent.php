<?php

namespace App\Repositories\Interfaces;

interface Eloquent
{
    public function getModel();

    public function setConnection();
}
