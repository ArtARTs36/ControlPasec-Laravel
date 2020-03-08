<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOneTFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('one_t_forms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->integer('order_number');
            $table->unsignedInteger('supply_id');

            $table->foreign('supply_id')
                ->references('id')
                ->on('supplies');
        });

        Schema::create('document_one_t_form', function (Blueprint $table) {
            $table->unsignedInteger('document_id');
            $table->unsignedInteger('one_t_form_id');

            $table->foreign('document_id')
                ->references('id')
                ->on('documents');

            $table->foreign('one_t_form_id')
                ->references('id')
                ->on('one_t_forms');
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
