<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_employee', function (Blueprint $table) {
            $table->unsignedInteger('document_id');
            $table->unsignedInteger('employee_id');

            $table->foreign('document_id')
                ->references('id')
                ->on('documents');

            $table->foreign('employee_id')
                ->references('id')
                ->on(\Dba\ControlTime\Support\Proxy::getEmployeeTable());
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('document_employee');
    }
}
