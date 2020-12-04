<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_logs', function (Blueprint $table) {
            $table->id();
            $table->text('ip')->comment('操作IP');
            $table->text('action')->comment('動作');
            $table->text('device')->nullable()->comment('user-agent');
            $table->text('post')->comment('post');
            $table->text('get')->comment('get');
            $table->text('session')->nullable()->comment('session');
            $table->text('response')->nullable()->comment('response');
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
        Schema::dropIfExists('admin_logs');
    }
}
