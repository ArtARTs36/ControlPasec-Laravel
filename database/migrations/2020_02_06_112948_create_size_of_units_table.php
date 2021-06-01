<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSizeOfUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('size_of_units', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Идентификатор');
            $table->timestamp('created_at')->nullable()->comment('Дата создания');
            $table->timestamp('updated_at')->nullable()->comment('Дата обновления');

            $table->string('name', 15)->comment('Название');
            $table->string('short_name', 15)->comment('Короткое название');
            $table->string('name_en', 15)->comment('Название (англ.)');
            $table->string('short_name_en', 15)->comment('Короткое назваие (англ.)');
            $table->integer('okei')->comment('Код ОКЕЙ');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('size_of_units');
    }
}
