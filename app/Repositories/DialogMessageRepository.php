<?php

namespace App\Repositories;

use App\Http\Resource\UserReceivedMessagesCutResource;
use App\Models\Dialog\Dialog;
use App\Models\Dialog\DialogMessage;
use Illuminate\Http\Request;
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

    public static function create(Dialog $dialog, Request $request): DialogMessage
    {
        $message = new DialogMessage();
        $message->from_user_id = auth()->user()->id;
        $message->to_user_id = $dialog->getInterUser()->id;
        $message->dialog_id = $dialog->id;
        $message->is_read = false;
        $message->text = $request->text;
        $message->save();

        return $message;
    }
}
