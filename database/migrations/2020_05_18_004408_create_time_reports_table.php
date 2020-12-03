<?php

use App\Bundles\Employee\Models\TimeReport;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimeReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->unsignedInteger(TimeReport::FIELD_EMPLOYEE_ID);
            $table->date(TimeReport::FIELD_START_DATE);
            $table->date(TimeReport::FIELD_END_DATE);
            $table->integer(TimeReport::FIELD_TIMES_QUANTITY)->nullable();
            $table->unsignedInteger(TimeReport::FIELD_DOCUMENT_ID);

            $table->foreign(TimeReport::FIELD_EMPLOYEE_ID)
                ->references('id')
                ->on(\Dba\ControlTime\Support\Proxy::getEmployeeTable());

            $table->foreign(TimeReport::FIELD_DOCUMENT_ID)
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
        Schema::dropIfExists('time_report');
    }
}
