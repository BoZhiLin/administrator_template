<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->comment('所屬用戶');
            $table->string('coin', 50)->comment('幣別');
            $table->decimal('balance_available', 15, 8)->default(0)->comment('餘額');
            $table->decimal('balance_locked', 15, 8)->default(0)->comment('凍結額度');
            $table->timestamps();
            $table->unique([
                'user_id',
                'coin'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wallets');
    }
}
