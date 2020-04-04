<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLandingFeedBacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('landing_feed_backs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->string('people_title');
            $table->string('people_email');
            $table->string('people_phone');
            $table->string('message', 500);
            $table->string('ip');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('landing_feed_backs');
    }
}
