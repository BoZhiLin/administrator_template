<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDateRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('date_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('date_id')->comment('所屬約會');
            $table->unsignedInteger('signup_user_id')->comment('報名人ID');
            $table->boolean('is_matched')->default(false)->comment('是否配對成功');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('date_records');
    }
}
