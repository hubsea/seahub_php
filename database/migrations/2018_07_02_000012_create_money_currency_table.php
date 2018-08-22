<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoneyCurrencyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('money_currency', function (Blueprint $table) {
            $table->increments('id');
            $table->char('type','8')->comment('currency type');
            $table->char('name',10)->comment('currency name');
            $table->enum('del',['0','1'])->default('0');
        });
        Schema::table('company_main', function (Blueprint $table) {
            $table->tinyInteger('currency_id')->after('stock');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('money_currency');
        Schema::table('company_main', function (Blueprint $table) {
            $table->dropColumn('currency_id');
        });
    }
}
