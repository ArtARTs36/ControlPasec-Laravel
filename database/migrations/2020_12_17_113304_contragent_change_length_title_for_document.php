<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ContragentChangeLengthTitleForDocument extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contragents', function (Blueprint $table) {
            $table->string('title_for_document', 255)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contragents', function (Blueprint $table) {
            $table->string('title_for_document', 120)->change();
        });
    }
}
