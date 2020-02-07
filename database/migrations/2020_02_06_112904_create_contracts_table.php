<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    const TABLE = 'contracts';

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

            $table->string('title', 255);
            $table->date('planned_date')->nullable();
            $table->date('executed_date')->nullable();

            $table->unsignedInteger('supplier_id');
            $table->unsignedInteger('customer_id');
        });

        Schema::table(self::TABLE, function (Blueprint $table) {
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
