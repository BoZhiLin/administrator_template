<?php

namespace App\Tools\Interfaces;

interface SMSHandler
{
    public function handle(array $data);
}
