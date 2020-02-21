<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScoreForPaymentsTable extends Migration
{
    const TABLE = 'score_for_payments';

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

            $table->date('date');

            $table->unsignedInteger('supply_id');
            $table->unsignedInteger('contract_id')->nullable();
            $table->bigInteger('order_number')->nullable();
        });

        Schema::table(self::TABLE, function (Blueprint $table) {
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
        Schema::dropIfExists(self::TABLE);
    }
}
