<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVocabBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vocab_banks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->string('short_name', 155);
            $table->string('full_name', 255);

            $table->integer('bik');
            $table->string('score', 60);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vocab_banks');
    }
}
