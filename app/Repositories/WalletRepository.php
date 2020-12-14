<?php

namespace App\Repositories;

use App\Models\Wallet;

class WalletRepository extends Repository
{
    public function getByUser(int $user_id, string $coin)
    {
        return $this->getModel()->firstOrCreate(
                [
                    'user_id' => $user_id, 
                    'coin' => $coin
                ]
            );
    }

    public function getModel()
    {
        return (Wallet::class)::on($this->connection);
    }
}
