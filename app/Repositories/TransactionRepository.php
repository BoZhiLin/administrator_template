<?php

namespace App\Repositories;

use Latrell\Lock\Facades\Lock;

use App\Models\Wallet;

class TransactionRepository extends Repository
{
    /**
     * 依據使用者錢包，建立交易紀錄明細
     * 
     * @param Wallet $wallet
     * @param array $fields (value, type, link) link非必填
     */
    public static function createByWallet(Wallet $wallet, string $type, $value, array $link = null)
    {
        if ($value != 0) {
            $model = static::getModel();
            $transaction = new $model();
            $transaction->user_id = $wallet->user_id;
            $transaction->wallet_id = $wallet->id;
            $transaction->coin = $wallet->coin;
            $transaction->value = $value;
            $transaction->type = $type;

            if ($link) {
                $transaction->link = $link;
            }

            $lock_key = 'transaction@wallet:' . $wallet->id;

            try {
                Lock::acquire($lock_key);
                $transaction->before = $wallet->balance_available;
                $transaction->after = $wallet->balance_available + $value;
                $wallet->increment('balance_available', $value);
                $transaction->save();
            } finally {
                Lock::release($lock_key);
            }

            return $transaction;
        }
    }
    
    public static function getModel()
    {
        return \App\Models\Transaction::class;
    }
}
