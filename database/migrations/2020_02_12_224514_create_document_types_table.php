<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->string('name', 100);
            $table->string('title', 100);
            $table->string('template', 100);
            $table->string('paper_size', 10);
            $table->unsignedInteger('loader_id');
        });

        Schema::table('document_types', function (Blueprint $table) {
            $table->foreign('loader_id')
                ->references('id')
                ->on('document_loaders');
        });

        Schema::table('documents', function (Blueprint $table) {
            $table->foreign('type_id')
                ->references('id')
                ->on('document_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('document_types');
    }
}
