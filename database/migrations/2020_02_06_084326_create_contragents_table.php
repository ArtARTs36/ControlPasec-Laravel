<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContragentsTable extends Migration
{
    const TABLE = 'contragents';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Идентификатор');

            $table->string('title', 500)->comment('Название');
            $table->string('full_title', 500)->nullable()->comment('Полное название');
            $table->string('full_title_with_opf', 500)
                ->nullable()
                ->comment('Полное название с формой устройства');
            $table->string('title_for_document', 120)->comment('Название для документов');

            $table->bigInteger('inn')->comment('ИНН');
            $table->bigInteger('kpp')->nullable()->comment('КПП');

            $table->bigInteger('ogrn')->nullable()->comment('ОГРН');
            $table->bigInteger('okato')->nullable()->comment('ОКАТО');
            $table->bigInteger('oktmo')->nullable()->comment('ОКТМО');
            $table->string('okved')->nullable()->comment('ОКВЭД');
            $table->string('okved_type')->nullable()->comment('Тип ОКВЭД');

            $table->string('address', 255)->nullable()->comment('Адрес');
            $table->integer('address_postal')->nullable()->comment('Почтовый индекс');

            $table->integer('status')->comment('Статус');

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
        Schema::dropIfExists('contragents');
    }
}
