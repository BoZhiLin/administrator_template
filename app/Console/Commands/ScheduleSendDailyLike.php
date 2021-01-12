<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ScheduleSendDailyLike extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:send-like';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '每日發放LIKE (依據會員階級)';

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
        // TODO
    }
}
