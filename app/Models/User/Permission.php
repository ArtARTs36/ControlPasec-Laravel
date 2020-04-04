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

    const VOCAB_PACKAGE_TYPES_LIST_VIEW = 'vocab_package_types_list_view';

    const VOCAB_QUANTITY_UNITS_LIST_VIEW = 'vocab_package_quantity_units_list_view';

    const VOCAB_CURRENCIES_LIST_VIEW = 'vocab_currencies_list_view';

    const VOCAB_WORDS_LIST_VIEW = 'vocab_words_list_view';

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

            self::USER_GET_NOTIFICATION_USER_REGISTERED => 'Получать уведомления о регистрациях пользователей',
            self::USER_GET_NOTIFICATION_LANDING_FEED_BACK_CREATED => 'Получать уведомления об обратной связи',

            self::CONTRACTS_LIST_VIEW => 'Просмотр списка договоров',
            self::CONTRACTS_VIEW => 'Просмотр договора',
            self::CONTRACTS_CREATE => 'Создание договора',
            self::CONTRACTS_EDIT => 'Редактирование договора',
            self::CONTRACTS_DELETE => 'Удаление договора',

            self::PRODUCTS_LIST_VIEW => 'Просмотр списка товаров',
            self::PRODUCTS_VIEW => 'Просмотр товара',
            self::PRODUCTS_CREATE => 'Создание товара',
            self::PRODUCTS_EDIT => 'Редактирование товара',
            self::PRODUCTS_DELETE => 'Удаление товара',

            self::EXTERNAL_NEWS_LIST_VIEW => 'Просмотр списка новостей из внешнего источников',
            self::EXTERNAL_NEWS_VIEW => 'Просмотр новостей из внешнего источника',
            self::EXTERNAL_NEWS_CREATE => 'Создание новостей из внешнего источника',
            self::EXTERNAL_NEWS_EDIT => 'Редактирование новостей из внешнего источника',
            self::EXTERNAL_NEWS_DELETE => 'Удаление новостей из внешнего источникаа',

            self::SCORE_FOR_PAYMENTS_LIST_VIEW => 'Просмотр списка счетов для оплаты',
            self::SCORE_FOR_PAYMENTS_VIEW => 'Просмотр счетов для оплаты',
            self::SCORE_FOR_PAYMENTS_CREATE => 'Создание счетов для оплаты',
            self::SCORE_FOR_PAYMENTS_EDIT => 'Редактирование счетов для оплаты',
            self::SCORE_FOR_PAYMENTS_DELETE => 'Удаление счетов для оплаты',

        ], self::getVocabTypes());
    }

    public static function getVocabTypes(): array
    {
        return [
            self::VOCABS_VIEW => 'Просмотр справочников',

            self::VOCAB_GOS_STANDARD_LIST_VIEW => 'Просмотр ГОСТов',

            self::VOCAB_BANKS_LIST_VIEW => 'Просмотр списка банков',

            self::VOCAB_PACKAGE_TYPES_LIST_VIEW => 'Просмотр справочника типов упаков',

            self::VOCAB_QUANTITY_UNITS_LIST_VIEW => 'Просмотр справочника единиц измерения количества',

            self::VOCAB_CURRENCIES_LIST_VIEW => 'Просмотр справочника валют',

            self::VOCAB_WORDS_LIST_VIEW => 'Просмотр справочника слов',

            self::VOCAB_SIZE_OF_UNIT_LIST_VIEW => 'Просмотр справочника единиц измерения массы',
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
