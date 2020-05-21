<?php

namespace App\Models\User;

use App\User;
use Illuminate\Database\Query\Builder;
use Spatie\Permission\Models\Permission as BasePermission;

/**
 * Class Permission
 * @property int $id
 * @property string $name
 * @property string $title
 * @property string $guard_name
 * @mixin Builder
 */
final class Permission extends BasePermission
{
    const SUPPLIES_VIEW = 'supplies_view';
    const SUPPLIES_CREATE = 'supplies_create';
    const SUPPLIES_EDIT = 'supplies_edit';
    const SUPPLIES_DELETE = 'supplies_delete';

    const USERS_VIEW = 'users_view';
    const USERS_LIST_VIEW = 'users_list_view';
    const USERS_ACTIVATE = 'users_activate';
    const USERS_DEACTIVATE = 'users_deactivate';
    const USERS_CREATE = 'users_create';

    const ROLE_LIST_VIEW = 'role_list_view';

    const PERMISSIONS_LIST_VIEW = 'permissions_list_view';

    const CONTRAGENTS_LIST_VIEW = 'contragents_list_view';
    const CONTRAGENTS_CREATE = 'contragents_create';
    const CONTRAGENTS_EDIT = 'contragents_edit';
    const CONTRAGENTS_DELETE = 'contragents_delete';
    const CONTRAGENTS_VIEW = 'contragents_view';
    const CONTRAGENTS_FIND_EXTERNAL_SYSTEM = 'contragents_find_external_system';

    const SETTINGS_VIEW = 'settings_view';
    const VARIABLE_DEFINITIONS_LIST_VIEW = 'variable_definitions_list_view';

    const VOCABS_VIEW = 'vocabs_view';

    const VOCAB_GOS_STANDARD_LIST_VIEW = 'vocab_gos_standard_list_view';
    const VOCAB_GOS_STANDARD_VIEW = 'vocab_gos_standard_view';
    const VOCAB_GOS_STANDARD_CREATE = 'vocab_gos_standard_create';
    const VOCAB_GOS_STANDARD_EDIT = 'vocab_gos_standard_edit';
    const VOCAB_GOS_STANDARD_DELETE = 'vocab_gos_standard_delete';

    const VOCAB_BANKS_LIST_VIEW = 'vocab_banks_list_view';
    const VOCAB_BANKS_VIEW = 'vocab_banks_view';
    const VOCAB_BANKS_EDIT = 'vocab_banks_edit';
    const VOCAB_BANKS_CREATE = 'vocab_banks_create';
    const VOCAB_BANKS_DELETE = 'vocab_banks_delete';

    const VOCAB_PACKAGE_TYPES_LIST_VIEW = 'vocab_package_types_list_view';
    const VOCAB_PACKAGE_TYPES_VIEW = 'vocab_package_types_view';
    const VOCAB_PACKAGE_TYPES_CREATE = 'vocab_package_types_create';
    const VOCAB_PACKAGE_TYPES_EDIT = 'vocab_package_types_edit';
    const VOCAB_PACKAGE_TYPES_DELETE = 'vocab_package_types_delete';

    const VOCAB_QUANTITY_UNITS_LIST_VIEW = 'vocab_package_quantity_units_list_view';
    const VOCAB_QUANTITY_UNITS_VIEW = 'vocab_package_quantity_units_view';
    const VOCAB_QUANTITY_UNITS_CREATE = 'vocab_package_quantity_units_create';
    const VOCAB_QUANTITY_UNITS_EDIT = 'vocab_package_quantity_units_edit';
    const VOCAB_QUANTITY_UNITS_DELETE = 'vocab_package_quantity_units_delete';

    const VOCAB_CURRENCIES_LIST_VIEW = 'vocab_currencies_list_view';
    const VOCAB_CURRENCIES_VIEW = 'vocab_currencies_view';
    const VOCAB_CURRENCIES_CREATE = 'vocab_currencies_create';
    const VOCAB_CURRENCIES_EDIT = 'vocab_currencies_edit';
    const VOCAB_CURRENCIES_DELETE = 'vocab_currencies_delete';

    const VOCAB_WORDS_LIST_VIEW = 'vocab_words_list_view';
    const VOCAB_WORDS_CREATE = 'vocab_words_create';
    const VOCAB_WORD_VIEW = 'vocab_words_view';
    const VOCAB_WORD_UPDATE = 'vocab_words_update';

    const VOCAB_SIZE_OF_UNIT_LIST_VIEW = 'vocab_size_of_unit_list_view';

    const USER_GET_NOTIFICATION_USER_REGISTERED = 'user_get_notification_user_registered';
    const USER_GET_NOTIFICATION_LANDING_FEED_BACK_CREATED = 'user_get_notification_landing_feed_back_created';

    const CONTRACTS_LIST_VIEW = 'contracts_list_view';
    const CONTRACTS_VIEW = 'contracts_view';
    const CONTRACTS_CREATE = 'contracts_create';
    const CONTRACTS_EDIT = 'contracts_edit';
    const CONTRACTS_DELETE = 'contracts_delete';

    const PRODUCTS_LIST_VIEW = 'products_list_view';
    const PRODUCTS_VIEW = 'products_view';
    const PRODUCTS_CREATE = 'products_create';
    const PRODUCTS_EDIT = 'products_edit';
    const PRODUCTS_DELETE = 'products_delete';
    const PRODUCTS_UPDATE = 'products_update';

    const EXTERNAL_NEWS_LIST_VIEW = 'external_news_list_view';
    const EXTERNAL_NEWS_VIEW = 'external_news_view';
    const EXTERNAL_NEWS_CREATE = 'external_news_create';
    const EXTERNAL_NEWS_EDIT = 'external_news_edit';
    const EXTERNAL_NEWS_DELETE = 'external_news_delete';

    const SCORE_FOR_PAYMENTS_LIST_VIEW = 'score_for_payments_list_view';
    const SCORE_FOR_PAYMENTS_VIEW = 'score_for_payments_view';
    const SCORE_FOR_PAYMENTS_CREATE = 'score_for_payments_create';
    const SCORE_FOR_PAYMENTS_EDIT = 'score_for_payments_edit';
    const SCORE_FOR_PAYMENTS_DELETE = 'score_for_payments_delete';

    public static function getAllNames()
    {
        return array_merge([
            static::SUPPLIES_VIEW => 'Просмотр поставок',
            static::SUPPLIES_CREATE => 'Создание поставки',
            static::SUPPLIES_EDIT => 'Редактирование поставки',
            static::SUPPLIES_DELETE => 'Удаление поставки',

            static::USERS_VIEW => 'Просмотр пользователя',
            static::USERS_LIST_VIEW => 'Просмотр списка пользователей',
            static::USERS_ACTIVATE => 'Активация профиля пользователя',
            static::USERS_DEACTIVATE => 'Деактивация профиля пользователя',
            static::USERS_CREATE => 'Создание пользователя',

            static::ROLE_LIST_VIEW => 'Просмотр списка ролей',

            static::PERMISSIONS_LIST_VIEW => 'Просмотр списка прав',

            static::CONTRAGENTS_LIST_VIEW => 'Просмотр списка контрагентов',
            static::CONTRAGENTS_CREATE => 'Создание контрагента',
            static::CONTRAGENTS_EDIT => 'Редактирование контрагента',
            static::CONTRAGENTS_DELETE => 'Удаление контрагента',
            static::CONTRAGENTS_VIEW => 'Просмотр контрагента',
            static::CONTRAGENTS_FIND_EXTERNAL_SYSTEM => 'Поиск контрагента во внешней системе',

            static::SETTINGS_VIEW => 'Просмотр настроек',
            static::VARIABLE_DEFINITIONS_LIST_VIEW => 'Просмотр определений переменных',

            static::USER_GET_NOTIFICATION_USER_REGISTERED => 'Получать уведомления о регистрациях пользователей',
            static::USER_GET_NOTIFICATION_LANDING_FEED_BACK_CREATED => 'Получать уведомления об обратной связи',

            static::CONTRACTS_LIST_VIEW => 'Просмотр списка договоров',
            static::CONTRACTS_VIEW => 'Просмотр договора',
            static::CONTRACTS_CREATE => 'Создание договора',
            static::CONTRACTS_EDIT => 'Редактирование договора',
            static::CONTRACTS_DELETE => 'Удаление договора',

            static::PRODUCTS_LIST_VIEW => 'Просмотр списка товаров',
            static::PRODUCTS_VIEW => 'Просмотр товара',
            static::PRODUCTS_CREATE => 'Создание товара',
            static::PRODUCTS_EDIT => 'Редактирование товара',
            static::PRODUCTS_DELETE => 'Удаление товара',
            static::PRODUCTS_UPDATE => 'Обновление товара',

            static::EXTERNAL_NEWS_LIST_VIEW => 'Просмотр списка новостей из внешнего источников',
            static::EXTERNAL_NEWS_VIEW => 'Просмотр новостей из внешнего источника',
            static::EXTERNAL_NEWS_CREATE => 'Создание новостей из внешнего источника',
            static::EXTERNAL_NEWS_EDIT => 'Редактирование новостей из внешнего источника',
            static::EXTERNAL_NEWS_DELETE => 'Удаление новостей из внешнего источникаа',

            static::SCORE_FOR_PAYMENTS_LIST_VIEW => 'Просмотр списка счетов для оплаты',
            static::SCORE_FOR_PAYMENTS_VIEW => 'Просмотр счетов для оплаты',
            static::SCORE_FOR_PAYMENTS_CREATE => 'Создание счетов для оплаты',
            static::SCORE_FOR_PAYMENTS_EDIT => 'Редактирование счетов для оплаты',
            static::SCORE_FOR_PAYMENTS_DELETE => 'Удаление счетов для оплаты',

        ], static::getVocabTypes());
    }

    public static function getVocabTypes(): array
    {
        return [
            static::VOCABS_VIEW => 'Просмотр справочников',

            static::VOCAB_GOS_STANDARD_LIST_VIEW => 'Просмотр ГОСТов',
            static::VOCAB_GOS_STANDARD_VIEW => 'Просмотр ГОСТа',
            static::VOCAB_GOS_STANDARD_EDIT => 'Редактирование госта',
            static::VOCAB_GOS_STANDARD_CREATE => 'Создание ГОСТА',
            static::VOCAB_GOS_STANDARD_DELETE => 'Удаление ГОСТА',

            static::VOCAB_BANKS_LIST_VIEW => 'Просмотр списка банков',
            static::VOCAB_BANKS_VIEW => 'Просмотр банка',
            static::VOCAB_BANKS_EDIT => 'Редактирование банка',
            static::VOCAB_BANKS_CREATE => 'Добавление банка',
            static::VOCAB_BANKS_DELETE => 'Удаление банка',

            static::VOCAB_PACKAGE_TYPES_LIST_VIEW => 'Просмотр справочника типов упаковок',
            static::VOCAB_PACKAGE_TYPES_VIEW => 'Просмотр типа упаковки',
            static::VOCAB_PACKAGE_TYPES_CREATE => 'Добавление типа упаковки',
            static::VOCAB_PACKAGE_TYPES_EDIT => 'Редактирование типа упаковки',
            static::VOCAB_PACKAGE_TYPES_DELETE => 'Удаление типа упаковки',

            static::VOCAB_QUANTITY_UNITS_LIST_VIEW => 'Просмотр справочника единиц измерения количества',
            static::VOCAB_QUANTITY_UNITS_VIEW => 'Просмотр единицы измерения количества',
            static::VOCAB_QUANTITY_UNITS_EDIT => 'Редактирование единицы измерения количества',
            static::VOCAB_QUANTITY_UNITS_CREATE => 'Создание единицы измерения количества',
            static::VOCAB_QUANTITY_UNITS_DELETE => 'Удаление единицы измерения количества',

            static::VOCAB_CURRENCIES_LIST_VIEW => 'Просмотр справочника валют',
            static::VOCAB_CURRENCIES_VIEW => 'Просмотр валюты',
            static::VOCAB_CURRENCIES_CREATE => 'Создание валюты',
            static::VOCAB_CURRENCIES_DELETE => 'Удаление валюты',
            static::VOCAB_CURRENCIES_EDIT => 'Редактирование валюты',

            static::VOCAB_WORDS_LIST_VIEW => 'Просмотр справочника слов',
            static::VOCAB_WORDS_CREATE => 'Создание слов в словаре',
            static::VOCAB_WORD_VIEW => 'Просмотр слова в словаре',
            static::VOCAB_WORD_UPDATE => 'Обновления слова в словаре',

            static::VOCAB_SIZE_OF_UNIT_LIST_VIEW => 'Просмотр справочника единиц измерения массы',
        ];
    }

    /**
     * @return array|User[]
     */
    public function getUsers(): array
    {
        $roles = $this->roles()->get();

        $users = [];
        foreach ($roles as $role) {
            $users = array_merge($users, $role->users->getDictionary());
        }

        return $users;
    }
}
