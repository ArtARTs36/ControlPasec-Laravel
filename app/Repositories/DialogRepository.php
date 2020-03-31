<?php

namespace App\Repositories;

use App\Http\Resource\DialogsListResource;
use App\Models\Dialog\Dialog;
use App\User;

class DialogRepository
{
    /**
     * Искать последние 10 диалогов текущего пользователя
     * @param int $page
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public static function findByCurrentUser(int $page = 1)
    {
        $currentUserId = auth()->user()->id;

        $dialogs = Dialog::where('one_user_id', $currentUserId)
            ->orWhere('two_user_id', $currentUserId)
            ->latest('updated_at')
            ->paginate(10, ['*'], null, $page);

        return DialogsListResource::collection($dialogs);
    }

    public static function findByCurrentUserAndToUser(User $toUser): ?Dialog
    {
        $currentUserId = auth()->user()->id;

        return Dialog::where('one_user_id', $currentUserId)
            ->where('two_user_id', $toUser->id)
            ->orWhere('one_user_id', $toUser->id)
            ->where('two_user_id', $currentUserId)
            ->first();
    }

    public static function createByCurrentUserAndToUser(User $toUser): Dialog
    {
        $dialog = new Dialog();

        $dialog->one_user_id = auth()->user()->id;
        $dialog->two_user_id = $toUser->id;
        $dialog->is_one_user_hidden = false;
        $dialog->is_two_user_hidden = false;

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
        $dialog = self::findByCurrentUserAndToUser($toUser);
        if ($dialog === null) {
            $dialog = self::createByCurrentUserAndToUser($toUser);
        }

        return $dialog;
    }
}
