<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVocabWordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vocab_words', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->integer('type')->nullable();

            $table->string('nominative', 25);
            $table->string('dative', 25);
            $table->string('genitive', 25);
            $table->string('instrumental', 25);
            $table->string('prepositional', 25);

            $table->string('plural_nominative', 25)->nullable();
            $table->string('plural_dative', 25)->nullable();
            $table->string('plural_genitive', 25)->nullable();
            $table->string('plural_instrumental', 25)->nullable();
            $table->string('plural_prepositional', 25)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vocab_words');
    }
}
