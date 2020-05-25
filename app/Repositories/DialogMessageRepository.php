<?php

namespace App\Repositories;

use App\Models\Dialog\Dialog;
use App\Models\Dialog\DialogMessage;
use App\User;
use Illuminate\Support\Collection;

class DialogMessageRepository
{
    /**
     * Получить последние 10 сообщений, полученные текущим пользователем
     * @param User $user
     * @param int $count
     * @return Collection|DialogMessage[]
     */
    public static function findRecievedMessagesByUser(User $user, int $count = 10)
    {
        return DialogMessage::query()
            ->where(DialogMessage::FIELD_TO_USER_ID, $user->id)
            ->take($count)
            ->latest(DialogMessage::CREATED_AT)
            ->get();
    }

    /**
     * @param Dialog $dialog
     * @param User $user
     * @return DialogMessage|null
     */
    public static function getLastMessageOfDialogByUser(Dialog $dialog, User $user): ?DialogMessage
    {
        return $dialog->messages()
            ->where(DialogMessage::FIELD_FROM_USER_ID, $user->id)
            ->latest(DialogMessage::CREATED_AT)
            ->first();
    }
}
