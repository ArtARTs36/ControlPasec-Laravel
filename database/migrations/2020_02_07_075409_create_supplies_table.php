<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliesTable extends Migration
{
    const TABLE = 'supplies';

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

            $table->date('planned_date');
            $table->date('execute_date');

            $table->unsignedInteger('supplier_id');
            $table->unsignedInteger('customer_id');
        });

        Schema::table('supplies', function (Blueprint $table) {
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
        Schema::dropIfExists(self::TABLE);
    }
}
