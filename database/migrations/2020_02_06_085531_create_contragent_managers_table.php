<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContragentManagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contragent_managers', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Идентификатор');
            $table->timestamp('created_at')->nullable()->comment('Дата создания');
            $table->timestamp('updated_at')->nullable()->comment('Дата обновления');

            $table->string('name', 40)->comment('Имя');
            $table->string('patronymic', 40)->nullable()->comment('Отчество');
            $table->string('family', 40)->comment('Фамилия');

            $table->string('phone', 25)->nullable()->comment('Номер телефона');
            $table->string('email', 40)->nullable()->comment('Электронная почта');

            $table->string('post', 50)->nullable()->comment('Должность');

            $table->unsignedInteger('contragent_id')->comment('Идентификатор контрагента');

            $table->foreign('contragent_id')
                ->references('id')
                ->on('contragents')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contragent_managers');
    }
}
