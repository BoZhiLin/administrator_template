<?php

namespace App\Tools\Factories;

use App\Tools\Interfaces\SMSHandler;

class Nexmo implements SMSHandler
{
    public function handle(array $data)
    {
        $nexmo_key = config('services.nexmo.key');
        $nexmo_secret = config('services.nexmo.secret');
        $basic  = new \Nexmo\Client\Credentials\Basic($nexmo_key, $nexmo_secret);
        $client = new \Nexmo\Client($basic);
        
        $message = $client->message()->send([
            'to' => $data['to'],
            'from' => config('services.nexmo.sms_from'),
            'text' => $data['content']
        ]);

        // $message->toArray();
    }
}
