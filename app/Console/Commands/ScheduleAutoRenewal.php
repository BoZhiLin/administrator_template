<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Defined\TagDefined;
use App\Models\User;

class ScheduleAutoRenewal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:auto-renewal';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '會員自動續訂';

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
        $users = User::whereHas('tags', function ($query) {
            $query->where('type', TagDefined::VIP_AUTO_RENEWAL);
        })->get();

        // TODO

        $this->info('Success');
    }
}
