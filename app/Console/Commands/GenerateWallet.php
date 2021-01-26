<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Defined\CoinDefined;

use App\Models\User;

use App\Repositories\WalletRepository;

class GenerateWallet extends Command
{
    /**
     * WalletRepository for handling wallet entity.
     * 
     * @var WalletRepository
     */
    protected $walletRepo;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wallet:generate {--user=} {--coin=} {--value=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '建立使用者錢包';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(WalletRepository $walletRepo)
    {
        parent::__construct();
        $this->walletRepo = $walletRepo;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user_id = $this->option('user');
        $coin = $this->option('coin');
        $value = $this->option('value');

        if (!$user_id) {
            $this->error('User id is required');
        } elseif (!User::find($user_id)) {
            $this->error('User not found');
        } elseif (!in_array($coin, CoinDefined::all())) {
            $this->error('Coin not exists');
        } else {
            $user_id = (int) $user_id;
            $value = (int) $value;
            $wallet = $this->walletRepo->getByUser($user_id, $coin);
            $wallet->balance_available = $value;
            $wallet->save();
        }
    }
}
