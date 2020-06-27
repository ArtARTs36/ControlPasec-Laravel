<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQualityCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quality_certificates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->integer('order_number');
            $table->unsignedInteger('supply_id');

            $table->foreign('supply_id')
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
        Schema::dropIfExists('one_t_forms');
    }
}
