<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateProductTransportWaybillsTable
 *
 * Миграция для создания таблицы Товарно-транспортных накладных
 */
class CreateProductTransportWaybillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_transport_waybills', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->integer('order_number');
            $table->date('date');
            $table->unsignedInteger('supply_id');
        });

        Schema::table('product_transport_waybills', function (Blueprint $table) {
            $table->foreign('supply_id')
                ->references('id')
                ->on('supplies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_transport_waybills');
    }
}
