<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\User;

use App\Defined\CoinDefined;
use App\Defined\SystemDefined;
use App\Defined\VipTypeDefined;

use App\Repositories\UserRepository;
use App\Repositories\WalletRepository;

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
    protected $description = '發放每日LIKE配對數，若當日未使用完畢則不予累積';

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
        $day_likes = [
            VipTypeDefined::VISITOR => SystemDefined::VISITOR_DAY_LIKES,
            VipTypeDefined::GOLD => SystemDefined::GOLD_DAY_LIKES
        ];

        User::get()
            ->each(function ($user) use ($day_likes) {
                $vip_type = UserRepository::getVipLevel($user);
                $like_amount = $day_likes[$vip_type];

                /** 每日LIKE數重置 */
                $wallet = WalletRepository::getByUser($user->id, CoinDefined::DAY_LIKE);
                $wallet->balance_available = $like_amount;
                $wallet->save();
            });
    }
}
