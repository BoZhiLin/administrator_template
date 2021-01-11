<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_serial_number')->nullable()->comment('訂單序號');
            $table->unsignedInteger('user_id')->comment('所屬用戶');
            $table->string('type')->comment('訂單類型');
            $table->integer('amount')->comment('數量');
            $table->decimal('value', 15, 2)->comment('金額');
            $table->string('status')->comment('訂單狀態');
            $table->text('link')->nullable()->comment('附註資料');
            $table->text('remark')->nullable()->comment('訂單備註');
            $table->timestamps();
            $table->softDeletes();

            $table->index([
                'user_id'
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
        Schema::dropIfExists('orders');
    }
}
