<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSyncWithExternalSystemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('external_system_exchanges', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->unsignedInteger('system_id');
            $table->unsignedInteger('model_type_id');
            $table->integer('model_id');
            $table->json('response');

            $table->foreign('system_id')
                ->references('id')
                ->on('external_systems')
                ->onDelete('cascade');

            $table->foreign('model_type_id')
                ->references('id')
                ->on('model_types')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('external_system_exchanges');
    }
}
