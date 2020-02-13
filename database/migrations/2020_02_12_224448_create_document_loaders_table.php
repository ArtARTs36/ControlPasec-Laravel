<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentLoadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_loaders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->string('name', 30);
            $table->unsignedInteger('extension_id');
        });

        Schema::table('document_loaders', function (Blueprint $table) {
            $table->foreign('extension_id')
                ->references('id')
                ->on('document_extensions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('document_loaders');
    }
}
