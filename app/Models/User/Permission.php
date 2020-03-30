<?php

namespace App\Models\User;

use Illuminate\Database\Query\Builder;
use Spatie\Permission\Models\Permission as BasePermission;

/**
 * Class Permission
 * @property int id
 * @property string name
 * @property string title
 * @property string guard_name
 * @mixin Builder
 */
final class Permission extends BasePermission
{
    const SUPPLIES_VIEW = 'supplies_view';
    const SUPPLIES_CREATE = 'supplies_create';
    const SUPPLIES_EDIT = 'supplies_edit';

    const USERS_VIEW = 'users_view';
    const USERS_LIST_VIEW = 'users_list_view';
    const USERS_ACTIVATE = 'users_activate';
    const USERS_DEACTIVATE = 'users_deactivate';
    const USERS_CREATE = 'users_create';

    const ROLE_LIST_VIEW = 'role_list_view';

    const PERMISSIONS_LIST_VIEW = 'permissions_list_view';

    const CONTRAGENTS_LIST_VIEW = 'contragents_list_view';
    const CONTRAGENTS_FIND_EXTERNAL_SYSTEM = 'contragents_find_external_system';

    const SETTINGS_VIEW = 'settings_view';
    const VARIABLE_DEFINITIONS_LIST_VIEW = 'variable_definitions_list_view';

    const VOCABS_VIEW = 'vocabs_view';

    const VOCAB_GOS_STANDARD_LIST_VIEW = 'vocab_gos_standard_list_view';

    const VOCAB_BANKS_LIST_VIEW = 'vocab_banks_list_view';

    public static function getAllNames()
    {
        return [
            self::SUPPLIES_VIEW => 'Просмотр поставок',
            self::SUPPLIES_CREATE => 'Создание поставки',
            self::SUPPLIES_EDIT => 'Редактирование поставки',

            self::USERS_VIEW => 'Просмотр пользователя',
            self::USERS_LIST_VIEW => 'Просмотр списка пользователей',
            self::USERS_ACTIVATE => 'Активация профиля пользователя',
            self::USERS_DEACTIVATE => 'Деактивация профиля пользователя',
            self::USERS_CREATE => 'Создание пользователя',

            self::ROLE_LIST_VIEW => 'Просмотр списка ролей',

            self::PERMISSIONS_LIST_VIEW => 'Просмотр списка прав',

            self::CONTRAGENTS_LIST_VIEW => 'Просмотр списка контрагентов',
            self::CONTRAGENTS_FIND_EXTERNAL_SYSTEM => 'Поиск контрагента во внешней системе',

            self::SETTINGS_VIEW => 'Просмотр настроек',
            self::VARIABLE_DEFINITIONS_LIST_VIEW => 'Просмотр определений переменных',

            self::VOCABS_VIEW => 'Просмотр справочников',

            self::VOCAB_GOS_STANDARD_LIST_VIEW => 'Просмотр ГОСТов',

            self::VOCAB_BANKS_LIST_VIEW => 'Просмотр списка банков',
        ];
    }
}
