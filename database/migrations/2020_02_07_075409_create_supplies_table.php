<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplies', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Идентификатор');

            $table->timestamp('created_at')->nullable()->comment('Дата создания');
            $table->timestamp('updated_at')->nullable()->comment('Дата обновления');

            $table->date('planned_date')->comment('Планируемая дата поставки');
            $table->date('execute_date')->nullable()->comment('Фактическая дата поставки');

            $table->unsignedInteger('supplier_id')->comment('Идентификатор поставщика');
            $table->unsignedInteger('customer_id')->comment('Идентификатор заказчика');

            $table->foreign('supplier_id')
                ->references('id')
                ->on('contragents');

            $table->foreign('customer_id')
                ->references('id')
                ->on('contragents');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supplies');
    }
}
