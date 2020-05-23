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

            $table->string('name', 40);
            $table->string('patronymic', 40);
            $table->string('family', 40);

            $table->string('phone', 25)->nullable();
            $table->string('email', 40)->nullable();

            $table->string('post', 50)->nullable();

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
