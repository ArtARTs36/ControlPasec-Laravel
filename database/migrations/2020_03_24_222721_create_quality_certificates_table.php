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

        Schema::create('document_quality_certificate', function (Blueprint $table) {
            $table->unsignedInteger('document_id');
            $table->unsignedInteger('quality_certificate_id');

            $table->foreign('document_id')
                ->references('id')
                ->on('documents');

            $table->foreign('quality_certificate_id')
                ->references('id')
                ->on('quality_certificates');
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
