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
        Schema::create('work_conditions', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->timestamp('created_at')->nullable()->comment('Дата создания');
            $table->timestamp('updated_at')->nullable()->comment('Дата обновления');

            $table->string('position', 50)->nullable()->comment('Должность');
            $table->double('rate')->comment('Ставка');
            $table->unsignedInteger('employee_id')->comment('Идентификатор сотрудника');
            $table->integer('amount_hour')->comment('Сумма почасовой оплаты');
            $table->date('hire_date')->comment('Дата найма');
            $table->date('fire_date')->nullable()->comment('Дата увольнения');
            $table->string('tab_number')->comment('Табельный номер');

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
        Schema::dropIfExists('work_conditions');
    }
}
