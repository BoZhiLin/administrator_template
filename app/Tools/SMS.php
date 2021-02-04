<?php

namespace App\Tools;

use App\Tools\Interfaces\SMSHandler;

class SMS
{
    protected $smsHandler;

    public function __construct(SMSHandler $smsHandler)
    {
        $this->smsHandler = $smsHandler;    
    }

    public function send(array $data)
    {
        $this->smsHandler->handle($data);
    }
}
