<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentRecordsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('payment_records', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('amount');
            $table->decimal('refunded_amount')->default(0);
            $table->string('remark');
            $table->string('channel')->comment('支付渠道');
            $table->enum('status', ['paying', 'paid', 'refunded']);
            $table->string('payment_no')->nullable()->comment('提交给第三方支付编号');
            $table->string('transaction_no')->nullable()->comment('第三方返回交易流水号');
            $table->timestamps();

            $table->morphs('able');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('payment_records');
    }
}
