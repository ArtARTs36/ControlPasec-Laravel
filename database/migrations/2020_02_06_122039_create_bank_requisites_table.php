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
            $table->bigIncrements('id')->comment('Идентификатор');
            $table->timestamp('created_at')->nullable()->comment('Дата создания');
            $table->timestamp('updated_at')->nullable()->comment('Дата обновления');

            $table->string('score', 55)->comment('Номер счета');

            $table->unsignedInteger('contragent_id')->comment('Идентификатор контрагента');
            $table->unsignedInteger('bank_id')->comment('Идентификатор банка');

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
