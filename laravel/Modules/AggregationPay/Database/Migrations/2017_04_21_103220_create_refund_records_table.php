<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefundRecordsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('refund_records', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('amount');
            $table->string('remark');
            $table->enum('status', ['refunding', 'refunded', 'failure']);
            $table->string('refund_no')->nullable()->comment('提交给第三方退款编号');
            $table->string('transaction_no')->nullable()->comment('第三方返回交易流水号');
            $table->text('failure_reason')->nullable()->commit('失败原因');
            $table->timestamps();

            $table->morphs('able');

            $table->unsignedInteger('payment_record_id');
            $table->foreign('payment_record_id')->references('id')->on('payment_records')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('refund_records');
    }
}
