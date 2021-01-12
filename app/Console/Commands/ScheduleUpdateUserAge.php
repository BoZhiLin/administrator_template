<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\User;

use App\Tools\Tool;

class ScheduleUpdateUserAge extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:update-age';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '每日重算會員年齡';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        User::each(function ($user) {
            $age = Tool::getAge($user->birthday->toDateString());
            $user->age = $age;
            $user->save();
        });
    }
}
