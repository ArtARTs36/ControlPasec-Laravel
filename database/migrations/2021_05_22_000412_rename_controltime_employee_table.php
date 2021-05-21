<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameControltimeEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('controltime_employee', 'employees');

        Schema::table('controltime_times', function (Blueprint $table) {
            $table
                ->foreign('employee_id')
                ->references('id')
                ->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('employees', 'controltime_employee');

        Schema::table('controltime_times', function (Blueprint $table) {
            $table->dropForeign('employee_id');
        });
    }
}
