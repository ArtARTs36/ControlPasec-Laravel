<?php

namespace App\Based\Scopes;

use App\Models\User\UserNotification;
use App\User;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class UserNotificationsScope implements Scope
{
    /**
     * @param Builder $builder
     * @param Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model): void
    {
        $builder->with([User::RELATION_NOTIFICATIONS => function (HasMany $query) {
            $query
                ->latest(UserNotification::FIELD_CREATED_AT)
                ->where(UserNotification::FIELD_IS_READ, false);
        }]);
    }
}
