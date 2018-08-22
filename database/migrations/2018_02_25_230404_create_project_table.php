<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * Enterprise
         * Online company,if you have an idea make the world better ,please create an enterprise in seahub right now.
         */
        Schema::create('enterprise_main', function (Blueprint $table) {
            $table->increments('id');
            $table->char('name', 12)->comment('enterprise name');
            $table->integer('manager_id');
            $table->smallInteger('project_num')->default(0);
            $table->string('goal')->comment('why we can make world better');
            $table->text('goal_description');
            $table->decimal('coin', 20, 8)->comment('total seacoin');
            $table->decimal('left_coin', 20, 8)->comment('left seacoin');
            $table->bigInteger('capital_stock')->comment('the stock provide to seahub');
            $table->bigInteger('left_capital_stock')->comment('the left stock provide to seahub');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE `enterprise_main` comment 'enterprise main table'");
        /**
         *Enterprise Inflation model
         */
        Schema::create('enterprise_inflation_model', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('enterprise_id')->index();
            $table->timestamp('begin_time')->comment('this 100% stock distribution started at');
            $table->timestamp('end_time')->useCurrent()->comment('this 100% stock distribution ended at');
            $table->enum('inflation_stock_type', ['fixed', 'proportional'])->default('proportional');
            $table->bigInteger('capital_stock')->comment('after allocating 100% stock，every year proportional or fixed stock provide to creator');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE `enterprise_inflation_model` comment 'enterprise inflation model table'");
        /**
         * company
         * Offline enterprise
         */
        Schema::create('company_main', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('enterprise_id');
            $table->string('name')->comment('company name');
            $table->string('contact')->comment('contact information');
            $table->bigInteger('stock')->comment('the total stock of all company');
            $table->string('worth')->nullable()->comment('current value');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE `company_main` comment 'project-related companies'");
        /**
         * project
         */
        //项目主表
        Schema::create('project_main', function (Blueprint $table) {
            $table->increments('id');
            $table->char('name', 12)->comment('project name');
            $table->integer('manager_id');
            $table->mediumInteger('unit_num')->default(0);
            $table->decimal('coin', 20, 8)->comment('total seacoin');
            $table->decimal('left_coin', 20, 8)->comment('left seacoin');
            $table->bigInteger('capital_stock')->comment('the stock provide to seahub');
            $table->bigInteger('left_capital_stock')->comment('the left stock provide to seahub');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE `project_main` comment 'project main table'");
        //项目利益分配轮次
        Schema::create('project_assign_round', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->index();
            $table->tinyInteger('stage')->default(0)->comment('the stage of the project,start from 0');
            $table->timestamp('begin_time')->comment('this round start time');
            $table->timestamp('end_time')->useCurrent()->comment('this round end time');
            $table->enum('status', ['waiting', 'ing', 'finish'])->default('waiting');
            $table->smallInteger('unit_num')->default(0);
            $table->smallInteger('left_unit_num')->default(0);
            $table->decimal('coin', 20, 8)->comment('total seacoin');
            $table->decimal('left_coin', 20, 8)->comment('left seacoin');
            $table->bigInteger('capital_stock')->comment('the stock provide to seahub');
            $table->bigInteger('left_capital_stock')->comment('the left stock provide to seahub');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE `project_assign_round` comment 'shares are distributed round by round'");
        //项目分配单元
        Schema::create('project_assign_unit', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->index();
            $table->integer('assign_user_id')->comment('assignment of user');
            $table->integer('winner_id')->comment('user id who win the unit');
            $table->timestamp('begin_time')->comment('this unit work start time');
            $table->timestamp('end_time')->useCurrent()->comment('this unit work end time');
            $table->enum('status', ['registration', 'ing', 'review', 'finish'])->default('registration');
            $table->smallInteger('worker_count')->default(1);
            $table->smallInteger('worker_reward_coin')->default(0);
            $table->json('worker_ids')->nullable();
            $table->decimal('winner_reward_coin', 20, 8)->default(100)->comment('total seacoin');
            $table->integer('winner_reward_stock')->default(100)->comment('the project provide to unit');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE `project_assign_unit` comment 'project minimum allocation unit'");
        //项目角色
        Schema::create('project_role', function (Blueprint $table) {
            $table->increments('id');
            $table->char('name', 12)->comment('project role name');
            $table->string('desc', 1024)->comment('role description');
        });
        DB::statement("ALTER TABLE `project_role` comment 'project_role role table'");
        //角色和用户映射关系
        Schema::create('project_partner', function (Blueprint $table) {
            $table->increments('id');
            $table->char('name', 12)->comment('project name');
            $table->integer('project_id')->index();
            $table->integer('creator_id')->index();
            $table->timestamps();
        });
        DB::statement("ALTER TABLE `project_partner` comment 'project participants'");

        /**
         * git
         */
        Schema::create('git_main', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->comment('project id');
            $table->enum('platform', ['github', 'gitlab', 'gittea'])->default('gitlab')->comment('company name');
            $table->string('deploy_token')->comment('control source hub');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE `git_main` comment 'third party git management main table'");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enterprise_main');
        Schema::dropIfExists('enterprise_inflation_model');
        Schema::dropIfExists('company_main');
        Schema::dropIfExists('project_main');
        Schema::dropIfExists('project_assign_round');
        Schema::dropIfExists('project_assign_unit');
        Schema::dropIfExists('project_role');
        Schema::dropIfExists('project_partner');
        Schema::dropIfExists('git_main');
    }
}
