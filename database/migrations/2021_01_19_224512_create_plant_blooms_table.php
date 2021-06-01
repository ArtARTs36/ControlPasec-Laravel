<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlantBloomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plant_blooms', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Идентификатор');

            $table->timestamp('created_at')->nullable()->comment('Дата создания');
            $table->timestamp('updated_at')->nullable()->comment('Дата обновления');

            $table->integer('start_month')->comment('Начало цветения. Месяц');
            $table->integer('start_day')->comment('Начало цветения. День');

            $table->integer('end_month')->comment('Конец цветения. Месяц');
            $table->integer('end_day')->comment('Конец цветения. Месяц');

            $table->unsignedBigInteger('plant_id')->comment('Идентификатор растения');
            $table->foreign('plant_id')
                ->on('plants')
                ->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plant_blooms');
    }
}
