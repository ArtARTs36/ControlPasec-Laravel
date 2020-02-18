<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnQuantityIdInSupplyProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('supply_products', function (Blueprint $table) {
            $table->unsignedInteger('quantity_unit_id');

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
        Schema::table('supply_products', function (Blueprint $table) {
            //
        });
    }
}
