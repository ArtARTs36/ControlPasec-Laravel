<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContragentsTable extends Migration
{
    const TABLE = 'contragents';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->bigIncrements('id');

            //$table->string('title', 500)->unique();
            $table->string('title', 500);
            $table->string('full_title', 500)->nullable();
            $table->string('full_title_with_opf', 500)->nullable();

            $table->bigInteger('inn');
            $table->bigInteger('kpp')->nullable();

            $table->bigInteger('ogrn')->nullable();
            $table->bigInteger('okato')->nullable();
            $table->bigInteger('oktmo')->nullable();
            $table->string('okved')->nullable();
            $table->string('okved_type')->nullable();

            $table->string('address', 255)->nullable();
            $table->integer('address_postal')->nullable();

            $table->integer('status');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contragents');
    }
}
