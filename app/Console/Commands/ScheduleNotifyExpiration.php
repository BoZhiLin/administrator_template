<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Defined\SystemDefined;

use App\Models\User;

use App\Repositories\UserRepository;

use App\Jobs\SendExpirationMail;

class ScheduleNotifyExpiration extends Command
{
    /**
     * UserRepository for handling user entity.
     * 
     * @var UserRepository
     */
    protected $userRepo;

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
    public function __construct(UserRepository $userRepo)
    {
        parent::__construct();
        $this->userRepo = $userRepo;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        User::has('vips')
            ->with(['vips'])
            ->get()
            ->each(function ($user) {
                $vip_type = $this->userRepo->getVipLevel($user);
                $current_vip = $user->vips()
                    ->where('type', $vip_type)
                    ->whereDate('expired_at', today()->addDays(SystemDefined::EXPIRATION_NOTIFY_DAYS))
                    ->first();

                if (!is_null($current_vip)) {
                    SendExpirationMail::dispatch($user, [
                        'expired_at' => $current_vip->expired_at
                    ]);
                }
            });
    }
}
