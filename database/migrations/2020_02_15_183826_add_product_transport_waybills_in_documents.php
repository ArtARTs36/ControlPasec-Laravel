<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductTransportWaybillsInDocuments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_product_transport_waybill', function (Blueprint $table) {
            $table->unsignedInteger('document_id');
            $table->unsignedInteger('product_transport_waybill_id');
        });

        Schema::table('document_product_transport_waybill', function (Blueprint $table) {
            $table->foreign('document_id')
                ->references('id')
                ->on('documents');

            $table->foreign('product_transport_waybill_id')
                ->references('id')
                ->on('product_transport_waybills');
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
