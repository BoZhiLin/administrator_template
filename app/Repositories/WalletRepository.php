<?php

namespace App\Repositories;

use Latrell\Lock\Facades\Lock;

class WalletRepository extends Repository
{
    public static function getByUser(int $user_id, string $coin)
    {
        $lock_key = 'wallet@user:' . $user_id;

        try {
            Lock::acquire($lock_key);

            $wallet = static::getModel()::firstOrCreate(
                ['user_id' => $user_id, 'coin' => $coin],
                ['balance_available' => 0]
            );
        } finally {
            Lock::release($lock_key);
        }

        return $wallet;
    }

    public static function getModel()
    {
        return \App\Models\Wallet::class;
    }
}
