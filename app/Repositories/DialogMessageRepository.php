<?php

namespace App\Repositories;

use App\Http\Resource\UserReceivedMessagesCutResource;
use App\Models\Dialog\DialogMessage;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class DialogMessageRepository
{
    /**
     * Получить последние 10 сообщений, полученные текущим пользователем
     * @return AnonymousResourceCollection|DialogMessage[]
     */
    public static function findRecievedMessagesByCurrentUser()
    {
        $currentUserId = auth()->user()->id;

        $dialogs = DialogMessage::where('to_user_id', $currentUserId)
            ->take(10)
            ->latest('created_at')
            ->get();

        return UserReceivedMessagesCutResource::collection($dialogs);
    }
}
