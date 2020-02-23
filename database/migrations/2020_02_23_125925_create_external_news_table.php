<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExternalNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('external_news', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->text('title');
            $table->text('description')->nullable();
            $table->dateTime('pub_date');
            $table->string('link', 150);

            $table->unsignedInteger('source_id');
        });

        Schema::table('external_news', function (Blueprint $table) {
            $table->foreign('source_id')
                ->references('id')
                ->on('external_news_sources');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('external_news');
    }
}
