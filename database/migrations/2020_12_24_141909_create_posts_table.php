<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->comment('所屬用戶');
            $table->longText('content')->comment('內容');
            $table->timestamps();
            $table->softDeletes();
        });

        // 打亂初始ID
        DB::unprepared('ALTER TABLE `posts` AUTO_INCREMENT = ' . mt_rand(10000, 20000) . ';');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
