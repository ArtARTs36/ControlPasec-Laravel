<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDocumentIdInScoreForPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('score_for_payments', function (Blueprint $table) {
            $table->unsignedInteger('document_id');

            $table->foreign('document_id')
                ->references('id')
                ->on('documents');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('score_of_payment', function (Blueprint $table) {
            $table->removeColumn('document_id');
            $table->dropForeign('document_id');
        });
    }
}
