<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSuppliesInDocuments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_supply', function (Blueprint $table) {
            $table->unsignedInteger('document_id');
            $table->unsignedInteger('supply_id');
        });

        Schema::table('document_supply', function (Blueprint $table) {
            $table->foreign('document_id')
                ->references('id')
                ->on('documents');

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
        Schema::table('documents', function (Blueprint $table) {
            //
        });
    }
}
