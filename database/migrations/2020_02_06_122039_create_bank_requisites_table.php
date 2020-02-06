<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankRequisitesTable extends Migration
{
    const TABLE = 'bank_requisites';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->string('score', 55);

            $table->unsignedInteger('contragent_id');
            $table->unsignedInteger('bank_id');
        });

        Schema::table(self::TABLE, function (Blueprint $table) {
            $table->foreign('contragent_id')
                ->references('id')
                ->on('contragents')
                ->onDelete('cascade');

            $table->foreign('bank_id')
                ->references('id')
                ->on('vocab_banks')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bank_requisites');
    }
}
