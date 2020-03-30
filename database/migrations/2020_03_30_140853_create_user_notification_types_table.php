<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserNotificationTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_notification_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->string('title');
            $table->string('name');

            $table->unsignedInteger('permission_id');

            $table->foreign('permission_id')
                ->references('id')
                ->on('permissions');

            $table->unsignedInteger('about_model_type_id')->nullable();

            $table->foreign('about_model_type_id')
                ->references('id')
                ->on('model_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_notification_types');
    }
}
