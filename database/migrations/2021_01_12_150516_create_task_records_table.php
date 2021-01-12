<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->comment('所屬用戶');
            $table->unsignedInteger('task_id')->comment('所屬任務');
            $table->string('reward_type')->comment('獎勵類別');
            $table->integer('reward_value')->comment('獎勵數量');
            $table->text('link')->nullable()->comment('附屬資料');
            $table->timestamp('completed_at')->comment('完成時間');
            $table->timestamps();
            $table->softDeletes();

            $table->index([
                'user_id',
                'task_id'
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
        Schema::dropIfExists('task_records');
    }
}
