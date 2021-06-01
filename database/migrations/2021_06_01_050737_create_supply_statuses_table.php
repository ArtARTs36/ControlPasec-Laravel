<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplyStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supply_statuses', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Идентификатор');

            $table->string('title')->comment('Название');
            $table->string('slug')->comment('Кодовое название');

            $table->timestamp('created_at')->nullable()->comment('Дата создания');

            $table->timestamp('updated_at')->nullable()->comment('Дата обновления');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supply_statuses');
    }
}
