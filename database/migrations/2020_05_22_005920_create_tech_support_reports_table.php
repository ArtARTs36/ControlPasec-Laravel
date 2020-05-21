<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTechSupportReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tech_support_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->string('message', 1000);
            $table->string('author_contact', 100)->nullable();
            $table->string('author_title', 100)->nullable();
            $table->string('ip', 20);
            $table->boolean('is_read')->default(false);

            $table->unsignedInteger('user_id')->nullable();

            $table->foreign('user_id')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tech_support_reports');
    }
}
