<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->timestamps();

            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')
                ->on('plant_categories')
                ->references('id');

            $table->integer('bloom_start_month');
            $table->integer('bloom_start_day');

            $table->integer('bloom_end_month');
            $table->integer('bloom_end_day');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plants');
    }
}
