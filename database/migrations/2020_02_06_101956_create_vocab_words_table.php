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

            $table->string('nominative', 45);
            $table->string('dative', 45);
            $table->string('genitive', 45);
            $table->string('instrumental', 45);
            $table->string('prepositional', 45);

            $table->string('plural_nominative', 45)->nullable();
            $table->string('plural_dative', 45)->nullable();
            $table->string('plural_genitive', 45)->nullable();
            $table->string('plural_instrumental', 45)->nullable();
            $table->string('plural_prepositional', 45)->nullable();
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
