<?php

use App\Bundles\Employee\Models\Employee;
use ArtARTs36\ControlTime\Support\Proxy;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateEmployeesTable
 */
class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Proxy::getEmployeeTable(), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->string(Employee::FIELD_FAMILY, 20);
            $table->string(Employee::FIELD_NAME, 20);
            $table->string(Employee::FIELD_PATRONYMIC, 20);
            $table->date(Employee::FIELD_HIRED_DATE);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Proxy::getEmployeeTable());
    }
}
