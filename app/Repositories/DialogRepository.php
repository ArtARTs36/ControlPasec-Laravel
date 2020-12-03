<?php

namespace App\Repositories;

use App\Based\Contracts\Repository;
use App\Http\Resource\DialogsListResource;
use App\Bundles\User\Models\Dialog;
use App\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class DialogRepository extends Repository
{
    /**
     * Искать последние 10 диалогов пользователя
     */
    public function findByUser(User $user, int $page = 1): AnonymousResourceCollection
    {
        $dialogs = Dialog::query()
            ->where(Dialog::FIELD_ONE_USER_ID, $user->id)
            ->orWhere(Dialog::FIELD_TWO_USER_ID, $user->id)
            ->latest(Dialog::FIELD_UPDATED_AT)
            ->paginate(10, ['*'], 'DialogsList', $page);

        return DialogsListResource::collection($dialogs);
    }

    public function findByCurrentUserAndToUser(User $author, User $toUser): ?Dialog
    {
        return Dialog::query()
            ->where(Dialog::FIELD_ONE_USER_ID, $author->id)
            ->where(Dialog::FIELD_TWO_USER_ID, $toUser->id)
            ->orWhere(Dialog::FIELD_ONE_USER_ID, $toUser->id)
            ->where(Dialog::FIELD_TWO_USER_ID, $author->id)
            ->first();
    }

    public function create(User $author, User $recipient): Dialog
    {
        $dialog = new Dialog();

        $dialog->one_user_id = $author->id;
        $dialog->two_user_id = $recipient->id;

        $dialog->save();

        return $dialog;
    }

    /**
     * Получить или создать диалог
     * @param User $recipient
     * @return Dialog
     */
    public function getOrCreate(User $author, User $recipient): Dialog
    {
        $dialog = $this->findByCurrentUserAndToUser($author, $recipient);

        if ($dialog === null) {
            $dialog = $this->create($author, $recipient);
        }

        return $dialog;
    }

    /**
     * @param int $page
     * @return LengthAwarePaginator
     */
    public function paginate(int $page): LengthAwarePaginator
    {
        return Dialog::query()
            ->latest()
            ->paginate(10, ['*'], 'DialogsList', $page);
    }
}
