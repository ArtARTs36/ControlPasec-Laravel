<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    const TABLE = 'products';

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

            $table->string('name', 50);
            $table->string('name_for_document', 50);

            $table->integer('size');
            $table->unsignedInteger('size_of_unit_id');

            $table->bigInteger('price');
            $table->unsignedInteger('price_of_unit_id');
        });

        Schema::table(self::TABLE, function (Blueprint $table) {
            $table->foreign('size_of_unit_id')
                ->references('id')
                ->on('size_of_units');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
