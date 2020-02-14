<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddScoreForPaymentsInDocuments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_score_for_payment', function (Blueprint $table) {
            $table->unsignedInteger('document_id');
            $table->unsignedInteger('score_for_payment_id');
        });

        Schema::table('document_score_for_payment', function (Blueprint $table) {
            $table->foreign('document_id')
                ->references('id')
                ->on('documents');

            $table->foreign('score_for_payment_id')
                ->references('id')
                ->on('score_for_payments');
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
