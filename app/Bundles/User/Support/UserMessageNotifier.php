<?php

namespace App\Bundles\User\Support;

use App\Bundles\User\Repositories\UserNotificationRepository;
use App\Bundles\User\Repositories\UserNotificationTypeRepository;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class UserMessageNotifier
{
    private $typeRepository;

    private $repository;

    public function __construct(UserNotificationTypeRepository $typeRepository, UserNotificationRepository $repository)
    {
        $this->typeRepository = $typeRepository;
        $this->repository = $repository;
    }

    public function notify(string $type, string $message, Model $aboutModel): void
    {
        $type = $this->typeRepository->findByName($type);

        if ($type === null) {
            throw new \LogicException('Не верно задан тип уведомления!');
        }

        $this->repository->create(
            Arr::pluck($type->permission->getUsers(), User::FIELD_ID),
            $message,
            $type->id,
            $aboutModel->id
        );
    }
}
