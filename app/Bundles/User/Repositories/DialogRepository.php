<?php

namespace App\Repositories;

use App\Http\Resource\DialogsListResource;
use App\Models\Dialog\Dialog;
use App\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class DialogRepository
{
    /**
     * Искать последние 10 диалогов пользователя
     * @param User $user
     * @param int $page
     * @return AnonymousResourceCollection
     */
    public static function findByUser(User $user, int $page = 1): AnonymousResourceCollection
    {
        $dialogs = Dialog::query()
            ->where(Dialog::FIELD_ONE_USER_ID, $user->id)
            ->orWhere(Dialog::FIELD_TWO_USER_ID, $user->id)
            ->latest(Dialog::FIELD_UPDATED_AT)
            ->paginate(10, ['*'], 'DialogsList', $page);

        return DialogsListResource::collection($dialogs);
    }

    public static function findByCurrentUserAndToUser(User $toUser): ?Dialog
    {
        $currentUserId = auth()->user()->id;

        return Dialog::query()
            ->where(Dialog::FIELD_ONE_USER_ID, $currentUserId)
            ->where(Dialog::FIELD_TWO_USER_ID, $toUser->id)
            ->orWhere(Dialog::FIELD_ONE_USER_ID, $toUser->id)
            ->where(Dialog::FIELD_TWO_USER_ID, $currentUserId)
            ->first();
    }

    public static function createByCurrentUserAndToUser(User $toUser): Dialog
    {
        $dialog = new Dialog();

        $dialog->one_user_id = auth()->user()->id;
        $dialog->two_user_id = $toUser->id;

        $dialog->save();

        return $dialog;
    }

    /**
     * Получить или создать диалог
     * @param User $toUser
     * @return Dialog
     */
    public static function getOrCreate(User $toUser): Dialog
    {
        $dialog = static::findByCurrentUserAndToUser($toUser);
        if ($dialog === null) {
            $dialog = static::createByCurrentUserAndToUser($toUser);
        }

        return $dialog;
    }

    /**
     * @param int $page
     * @return LengthAwarePaginator
     */
    public static function paginate(int $page): LengthAwarePaginator
    {
        return Dialog::query()
            ->latest()
            ->paginate(10, ['*'], 'DialogsList', $page);
    }
}
