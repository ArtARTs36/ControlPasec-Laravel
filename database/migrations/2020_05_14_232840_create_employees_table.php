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
        Schema::create('controltime_employee', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->string('family', 20);
            $table->string('name', 20);
            $table->string('patronymic', 20);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('controltime_employee');
    }
}
