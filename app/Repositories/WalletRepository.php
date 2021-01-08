<?php

namespace App\Repositories;

class WalletRepository extends Repository
{
    public static function getByUser(int $user_id, string $coin)
    {
        return static::getModel()::firstOrCreate(
                [
                    'user_id' => $user_id, 
                    'coin' => $coin
                ]
            );
    }

    public static function getModel()
    {
        return \App\Models\Wallet::class;
    }
}
