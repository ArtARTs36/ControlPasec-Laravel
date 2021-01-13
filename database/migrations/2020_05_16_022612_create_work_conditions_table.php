<?php

use App\Bundles\Employee\Models\WorkCondition;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkConditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('controltime_work_conditions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->string('position', 50)->nullable();
            $table->double('rate');
            $table->unsignedInteger('employee_id');
            $table->integer('amount_hour');

            $table->foreign('employee_id')
                ->references('id')
                ->on('controltime_employee');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('controltime_work_conditions');
    }
}
