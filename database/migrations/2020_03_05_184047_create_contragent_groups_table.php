<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContragentGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contragent_groups', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Идентификатор');
            $table->timestamp('created_at')->nullable()->comment('Дата создания');
            $table->timestamp('updated_at')->nullable()->comment('Дата обновления');

            $table->string('name')->comment('Название');
        });

        Schema::create('contragent_group_related', function (Blueprint $table) {
            $table->unsignedInteger('group_id')->comment('Идентификатор группы');
            $table->unsignedInteger('contragent_id')->comment('Идентификатор контрагента');

            $table->foreign('group_id')
                ->references('id')
                ->on('contragent_groups')
                ->onDelete('cascade');

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
        Schema::dropIfExists('contragent_groups');
    }
}
