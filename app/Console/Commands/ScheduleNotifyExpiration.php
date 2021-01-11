<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Defined\SystemDefined;

class ScheduleNotifyExpiration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expiration:notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '會員即將到期通知';

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
        $days = SystemDefined::EXPIRATION_NOTIFY_DAYS;

        // TODO: Email通知
    }
}
