<?php

namespace App\Bundles\User\Services;

use App\Bundles\User\Models\Dialog;
use App\Bundles\User\Models\DialogMessage;
use App\Repositories\DialogMessageRepository;
use App\User;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

class DialogMessageService
{
    private $repository;

    public function __construct(DialogMessageRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param array|DialogMessage[] $messages
     */
    public function readMessages(array $messages): void
    {
        foreach ($messages as $message) {
            $message->read();
        }
    }

    /**
     * @param Dialog $dialog
     * @param User $user
     * @param string $text
     * @return DialogMessage|null
     */
    public function create(Dialog $dialog, User $user, string $text): ?DialogMessage
    {
        if ($this->isEqualsLastMessage($dialog, $user, $text)) {
            abort(Response::HTTP_CONFLICT, 'Вы уже отправляли сообщение с подобным содержанием');
        }

        $message = $dialog->messages()->make();
        $message->from_user_id = $user->id;
        $message->to_user_id = $dialog->getInterUser($user)->id;
        $message->text = $text;
        $message->save();

        return $message;
    }

    protected function isEqualsLastMessage(Dialog $dialog, User $user, string $text): bool
    {
        return ($msg = $this->repository->getLastMessageOfDialogByUser($dialog, $user)) && $msg->text === $text;
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
