<?php

namespace App\Bundles\User\Repositories;

use App\Bundles\User\Models\Dialog;
use App\Bundles\User\Models\DialogMessage;
use App\User;
use Illuminate\Support\Collection;

class DialogMessageRepository
{
    /**
     * Получить последние 10 сообщений, полученные текущим пользователем
     * @return Collection|DialogMessage[]
     */
    public function findRecievedMessagesByUser(User $user, int $count = 10): Collection
    {
        return $user->recievedDialogMessages()
            ->with([DialogMessage::RELATION_FROM_USER])
            ->take($count)
            ->latest(DialogMessage::CREATED_AT)
            ->get();
    }

    public function getLastMessageOfDialogByUser(Dialog $dialog, User $user): ?DialogMessage
    {
        return $dialog->messages()
            ->where(DialogMessage::FIELD_FROM_USER_ID, $user->id)
            ->latest(DialogMessage::CREATED_AT)
            ->first();
    }
}
