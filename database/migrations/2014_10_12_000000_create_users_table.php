<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Идентификатор');
            $table->string('name')->comment('Имя');
            $table->string('patronymic')->comment('Отчество');
            $table->string('family')->comment('Фамилия');
            $table->string('email')->unique()->comment('Электронная почта');
            $table->boolean('is_active')->comment('Активность УЗ');
            $table->string('avatar_url')->nullable()->comment('Ссылка на фото');
            $table->integer('gender')->nullable()->comment('Пол');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->comment('Хэш пароля');
            $table->string('position')->nullable()->comment('Основная роль');
            $table->string('about_me', 500)->nullable()->comment('Информация о себе');
            $table->rememberToken();

            $table->timestamp('created_at')->nullable()->comment('Дата создания УЗ');
            $table->timestamp('updated_at')->nullable()->comment('Дата обновления УЗ');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
