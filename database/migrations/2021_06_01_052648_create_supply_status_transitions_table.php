<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplyStatusTransitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supply_status_transitions', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Идентификатор перехода');

            $table->unsignedBigInteger('from_status_id')->comment('Прежний статус');
            $table
                ->foreign('from_status_id')
                ->references('id')
                ->on('supply_statuses');

            $table->unsignedBigInteger('to_status_id')->comment('Новый статус');
            $table
                ->foreign('to_status_id')
                ->references('id')
                ->on('supply_statuses');

            $table->unsignedBigInteger('user_id')->comment('Пользователь, выполнивший переход');
            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->dateTime('executed_at')->comment('Дата и время выполнения перехода');

            $table->unsignedBigInteger('supply_id')->comment('Идентификатор поставки');
            $table
                ->foreign('supply_id')
                ->references('id')
                ->on('supplies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supply_status_transitions');
    }
}
