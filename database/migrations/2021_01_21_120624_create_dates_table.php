<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dates', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('publisher_id')->comment('發起人');
            $table->unsignedInteger('match_id')->nullable()->comment('成功配對對象');
            $table->string('title')->comment('約會標題');
            $table->string('description')->comment('約會描述');
            $table->timestamp('opened_at')->nullable()->comment('開放報名時間');
            $table->timestamp('closed_at')->nullable()->comment('報名截止時間');
            $table->timestamps();
        });

        // 打亂初始ID。
        DB::unprepared('ALTER TABLE `dates` AUTO_INCREMENT = ' . mt_rand(100000, 200000) . ';');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dates');
    }
}
