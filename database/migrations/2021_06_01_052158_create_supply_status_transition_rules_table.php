<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplyStatusTransitionRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supply_status_transition_rules', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Идентификатор правила');

            $table->unsignedBigInteger('from_status_id')->nullable()->comment('Прежний статус');
            $table
                ->foreign('from_status_id')
                ->references('id')
                ->on('supply_statuses');

            $table->unsignedBigInteger('to_status_id')->comment('Новый статус');
            $table
                ->foreign('to_status_id')
                ->references('id')
                ->on('supply_statuses');

            $table
                ->unsignedBigInteger('creator_id')
                ->nullable()
                ->comment('Пользователь, создавший правило');
            $table
                ->foreign('creator_id')
                ->references('id')
                ->on('users');

            $table->unique(['from_status_id', 'to_status_id']);

            $table->string('title')->comment('Название процесса');

            $table->dateTime('created_at')->comment('Дата и время создания');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supply_status_transition_rules');
    }
}
