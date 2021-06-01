<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemSnapshotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_snapshots', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Идентификатор');

            $table->string('disk_name')->comment('Названия диска');
            $table->integer('disk_available')->comment('Доступное дисковое пространство');
            $table->integer('disk_used')->comment('Использованое дисковое пространство');
            $table->integer('disk_total')->comment('Общее дисковое пространство');

            $table->float('cpu_user_usage')->comment('Использование процессора пользователем');
            $table->float('cpu_system_usage')->comment('Использование процессора системой');
            $table->float('cpu_idle')->comment('Бездействие системы');

            $table->date('created_at')->comment('Дата создания');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_snapshots');
    }
}
