<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNectarProductivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nectar_productivity', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Идентификатор');

            $table->timestamp('created_at')->nullable()->comment('Дата создания');
            $table->timestamp('updated_at')->nullable()->comment('Дата обновления');

            $table->unsignedBigInteger('plant_id')->comment('Идентификатор растения');
            $table->foreign('plant_id')
                ->references('id')
                ->on('plants');

            $table->integer('nectar_min')->comment('Минимальный объем нектара');
            $table->integer('nectar_max')->comment('Максимальный объем нектара');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nectar_productivity');
    }
}
