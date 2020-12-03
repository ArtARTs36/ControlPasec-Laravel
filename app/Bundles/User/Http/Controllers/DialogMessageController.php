<?php

namespace App\Bundles\User\Http\Controllers;

use App\Bundles\User\Repositories\DialogRepository;
use App\Http\Controllers\Controller;
use App\Bundles\User\Http\Requests\StoreMessage;
use App\Bundles\User\Http\Resources\DialogMessageResource;
use App\Bundles\User\Models\Dialog;
use App\Bundles\User\Models\DialogMessage;
use App\Bundles\User\Services\DialogMessageService;
use App\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

final class DialogMessageController extends Controller
{
    private $dialogRepository;

    private $service;

    public function __construct(DialogRepository $dialogRepository, DialogMessageService $service)
    {
        $this->dialogRepository = $dialogRepository;
        $this->service = $service;
    }

    public function store(StoreMessage $request): DialogMessage
    {
        $currentUser = Auth::user();

        $toUser = User::query()->find($request->to_user_id);

        if (! $toUser) {
            throw new UnprocessableEntityHttpException('Указан некорректный пользователь');
        }

        $dialog = $this->dialogRepository->getOrCreate($currentUser, $toUser);

        return $this->service->create($dialog, $currentUser, $request->text);
    }

    public function createByDialog(Dialog $dialog, StoreMessage $request): DialogMessageResource
    {
        if ($dialog->isNotTookPart(Auth::user())) {
            throw new \LogicException('Вы не являетесь участником диалога');
        }

        $message = $this->service->create($dialog, Auth::user(), $request->text);

        return new DialogMessageResource($message);
    }

    public function read(DialogMessage $message): DialogMessage
    {
        return $message->read();
    }
}
