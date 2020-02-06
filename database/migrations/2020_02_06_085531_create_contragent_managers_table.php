<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContragentManagersTable extends Migration
{
    const TABLE = 'contragent_managers';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->string('name', 20);
            $table->string('patronymic', 20);
            $table->string('family', 20);

            $table->string('phone', 20);
            $table->string('email', 40);

            $table->string('post', 20);

            $table->unsignedInteger('contragent_id');
        });

        Schema::table(self::TABLE, function (Blueprint $table) {
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
