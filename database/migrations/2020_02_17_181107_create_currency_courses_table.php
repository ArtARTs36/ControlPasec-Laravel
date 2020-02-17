<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrencyCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currency_courses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->unsignedInteger('currency_id');
            $table->float('nominal');
            $table->float('value');
            $table->dateTimeTz('actual_date');
        });

        Schema::table('currency_courses', function (Blueprint $table) {
            $table->foreign('currency_id')
                ->references('id')
                ->on('vocab_currencies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currency_courses');
    }
}
