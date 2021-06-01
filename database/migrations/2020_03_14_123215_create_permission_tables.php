<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * @throws Exception
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Идентификатор');
            $table->string('name')->comment('Название');
            $table->string('guard_name')->comment('Область полномочия: web/api');
            $table->string('title')->comment('Кодовое название');
            $table->timestamp('created_at')->nullable()->comment('Дата создания');
            $table->timestamp('updated_at')->nullable()->comment('Дата обновления');
        });

        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Идентификатор');
            $table->string('name')->comment('Название');
            $table->string('guard_name')->comment('Область роли: web/api');
            $table->string('title')->comment('Кодовое название');
            $table->boolean('is_allowed_for_sign_up')->comment('Доступно ли для регистрации');
            $table->timestamp('created_at')->nullable()->comment('Дата создания');
            $table->timestamp('updated_at')->nullable()->comment('Дата обновления');
        });

        Schema::create('model_has_permissions', function (Blueprint $table) {
            $table->unsignedBigInteger('permission_id')->comment('Идентификатор полномочия');

            $table->string('model_type')->comment('Тип модели');
            $table->unsignedBigInteger('model_id')->comment('Идентификатор модели/пользователя');
            $table->index(['model_id', 'model_type'], 'model_has_permissions_model_id_model_type_index');

            $table->foreign('permission_id')
                ->references('id')
                ->on('permissions')
                ->onDelete('cascade');

            $table->primary(
                ['permission_id', 'model_id', 'model_type'],
                'model_has_permissions_permission_model_type_primary'
            );
        });

        Schema::create('model_has_roles', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id')->comment('Идентификатор роли');

            $table->string('model_type')->comment('Тип модели');
            $table->unsignedBigInteger('model_id')->comment('Идентификатор модели/пользователя');
            $table->index(['model_id', 'model_type'], 'model_has_roles_model_id_model_type_index');

            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onDelete('cascade');

            $table->primary(
                ['role_id', 'model_id', 'model_type'],
                'model_has_roles_role_model_type_primary'
            );
        });

        Schema::create('role_has_permissions', function (Blueprint $table) {
            $table->unsignedBigInteger('permission_id')->comment('Идентификатор полномочия');
            $table->unsignedBigInteger('role_id')->comment('Идентификатор роли');

            $table->foreign('permission_id')
                ->references('id')
                ->on('permissions')
                ->onDelete('cascade');

            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onDelete('cascade');

            $table->primary(['permission_id', 'role_id'], 'role_has_permissions_permission_id_role_id_primary');
        });

        app('cache')
            ->store(config('permission.cache.store') != 'default' ? config('permission.cache.store') : null)
            ->forget(config('permission.cache.key'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     * @throws Exception
     */
    public function down()
    {
        Schema::drop('role_has_permissions');
        Schema::drop('model_has_roles');
        Schema::drop('model_has_permissions');
        Schema::drop('roles');
        Schema::drop('permissions');
    }
}
