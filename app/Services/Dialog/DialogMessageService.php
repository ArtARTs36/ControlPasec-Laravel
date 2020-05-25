<?php

namespace App\Services\Dialog;

use App\Models\Dialog\Dialog;
use App\Models\Dialog\DialogMessage;
use App\Repositories\DialogMessageRepository;
use App\User;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

class DialogMessageService
{
    /**
     * @param array|DialogMessage[] $messages
     */
    public static function readMessages(array $messages): void
    {
        foreach ($messages as $message) {
            $message->read();
        }
    }

    /**
     * @return \Illuminate\Support\Collection|DialogMessage[]
     */
    public static function findRecievedMessagesByCurrentUser()
    {
        return DialogMessageRepository::findRecievedMessagesByUser(auth()->user());
    }

    /**
     * @param Dialog $dialog
     * @param User $user
     * @param string $text
     * @return DialogMessage|null
     */
    public static function create(Dialog $dialog, User $user, string $text): ?DialogMessage
    {
        if (($msg = DialogMessageRepository::getLastMessageOfDialogByUser($dialog, $user)) && $msg->text === $text) {
            abort(Response::HTTP_CONFLICT, 'Вы уже отправляли сообщение с подобным содержанием');
        }

        $message = $dialog->messages()->make();
        $message->from_user_id = $user->id;
        $message->to_user_id = $dialog->getInterUser()->id;
        $message->text = $text;
        $message->save();

        return $message;
    }

    /**
     * @param Collection|DialogMessage[] $messages
     * @return int
     */
    public static function bringUnReadCount(Collection $messages)
    {
        return $messages->filter(function (DialogMessage $message) {
            return $message->isNotRead();
        })->count();
    }
}
