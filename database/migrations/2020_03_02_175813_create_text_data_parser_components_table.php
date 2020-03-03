<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTextDataParserComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('text_data_parser_components', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->string('title', 50);
            $table->string('template', 50);
            $table->string('preparer', 50);
            $table->string('class', 75);
            $table->string('image', 75);
        });

        Schema::create('text_data_parser_components_model', function (Blueprint $table) {
            $table->unsignedInteger('component_id');
            $table->unsignedInteger('model_id');

            $table->foreign('component_id')
                ->references('id')
                ->on('text_data_parser_components');

            $table->foreign('model_id')
                ->references('id')
                ->on('model_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('text_data_parser_components');
    }
}
