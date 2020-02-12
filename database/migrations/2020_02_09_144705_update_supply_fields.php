<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSupplyFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('supplies', function (Blueprint $table) {
            $table->unsignedInteger('supplier_id');
            $table->unsignedInteger('customer_id');

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
        //
    }
}
