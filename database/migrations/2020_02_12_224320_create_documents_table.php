<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->unsignedInteger('type_id');
            $table->string('file_path', 256)->nullable();
            $table->string('title', 256);

            $table->dateTime('onePeriod')->nullable();
            $table->dateTime('twoPeriod')->nullable();

            $table->uuid('uuid');

            $table->integer('status');

            $table->bigInteger('folder')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
}
