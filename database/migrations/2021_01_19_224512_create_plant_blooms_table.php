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
            $table->bigIncrements('id');
            $table->timestamps();

            $table->integer('start_month');
            $table->integer('start_day');

            $table->integer('end_month');
            $table->integer('end_day');

            $table->unsignedBigInteger('plant_id');
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
