<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsInEmployees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('controltime_employee', function (Blueprint $table) {
            $table->date('holiday');
            $table->string('insurance_number', 15);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('controltime_employee', function (Blueprint $table) {
            $table->dropColumn([
               'holiday',
               'insurance_number',
            ]);
        });
    }
}
