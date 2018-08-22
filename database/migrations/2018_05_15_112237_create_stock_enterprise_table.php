<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockEnterpriseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_user', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
        });
        Schema::create('stock_enterprise_record', function (Blueprint $table) {
            $table->increments('id');
            $table->string('hash_pre')->comment('上一条数据的hash值');
            $table->integer('enterprise_id')->commet('公司id');
            $table->integer('stock_num')->commet('交易的股票数量');
            $table->integer('from_creator_id')->comment('转账接收人');
            $table->integer('to_creator_id')->comment('转账发送人');
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_enterprise');
        Schema::dropIfExists('stock_enterprise_record');
    }
}
