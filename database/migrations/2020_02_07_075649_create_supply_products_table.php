<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplyProductsTable extends Migration
{
    const TABLE = 'supply_products';

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

            $table->double('price');
            $table->integer('quantity');

            $table->unsignedInteger('product_id');
            $table->unsignedInteger('supply_id');
            $table->unsignedInteger('quantity_unit_id');
        });

        Schema::table(self::TABLE, function (Blueprint $table) {
            $table->foreign('product_id')
                ->references('id')
                ->on('products');

            $table->foreign('supply_id')
                ->references('id')
                ->on('supplies');

            $table->foreign('quantity_unit_id')
                ->references('id')
                ->on('vocab_quantity_units');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(self::TABLE);
    }
}
