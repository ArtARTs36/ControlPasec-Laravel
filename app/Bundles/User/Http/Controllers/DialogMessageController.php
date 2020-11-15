<?php

namespace App\Http\Controllers\Dialog;

use App\Http\Controllers\Controller;
use App\Http\Requests\DialogMessageRequest;
use App\Http\Resource\DialogMessageResource;
use App\Models\Dialog\Dialog;
use App\Models\Dialog\DialogMessage;
use App\Repositories\DialogMessageRepository;
use App\Repositories\DialogRepository;
use App\Services\Dialog\DialogMessageService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DialogMessageController extends Controller
{
    /**
     * @param DialogMessageRequest $request
     * @return DialogMessage
     */
    public function store(DialogMessageRequest $request): DialogMessage
    {
        $toUser = User::query()->find($request->to_user_id);

        $dialog = DialogRepository::getOrCreate($toUser);

        return DialogMessageService::create($dialog, auth()->user(), $request->text);
    }

    /**
     * @param Dialog $dialog
     * @param DialogMessageRequest $request
     * @return DialogMessageResource
     */
    public function createByDialog(Dialog $dialog, DialogMessageRequest $request): DialogMessageResource
    {
        if ($dialog->isNotTookPartCurrentUser()) {
            throw new \LogicException('Вы не являетесь участником диалога');
        }

        $message = DialogMessageService::create($dialog, auth()->user(), $request->text);

        return new DialogMessageResource($message);
    }

    /**
     * @param DialogMessage $message
     * @return DialogMessage
     */
    public function read(DialogMessage $message): DialogMessage
    {
        return $message->read();
    }
}
