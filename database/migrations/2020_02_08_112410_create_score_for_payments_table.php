<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScoreForPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('score_for_payments', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Идентификатор');
            $table->timestamp('created_at')->nullable()->comment('Дата создания');
            $table->timestamp('updated_at')->nullable()->comment('Дата обновления');

            $table->date('date')->comment('Дата');

            $table->unsignedInteger('supply_id')->comment('Идентификатор поставки');
            $table->unsignedInteger('contract_id')->nullable()->comment('Идентификатор договора');
            $table->bigInteger('order_number')->nullable()->comment('Порядковый номер');

            $table->foreign('supply_id')
                ->references('id')
                ->on('supplies');

            $table->foreign('contract_id')
                ->references('id')
                ->on('contracts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('score_for_payments');
    }
}
