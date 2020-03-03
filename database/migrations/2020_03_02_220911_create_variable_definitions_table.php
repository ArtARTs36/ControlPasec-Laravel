<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariableDefinitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variable_definitions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->string('name', 50);
            $table->string('value', 20);
            $table->string('description', 50);
            $table->boolean('is_take_of_parent')->nullable()->default(false);
            $table->unsignedInteger('model_type_id')->nullable();

            $table->foreign('model_type_id')
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
        Schema::dropIfExists('variable_definitions');
    }
}
