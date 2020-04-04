<?php

namespace App\Http\Controllers\Dialog;

use App\Http\Controllers\Controller;
use App\Http\Requests\DialogMessageRequest;
use App\Http\Resource\DialogMessageResource;
use App\Models\Dialog\Dialog;
use App\Models\Dialog\DialogMessage;
use App\Repositories\DialogMessageRepository;
use App\Repositories\DialogRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DialogMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DialogMessageRequest $request
     * @return DialogMessage
     */
    public function store(DialogMessageRequest $request): ?DialogMessage
    {
        $toUser = User::find($request->to_user_id);

        $dialog = DialogRepository::getOrCreate($toUser);

        $message = DialogMessageRepository::create($dialog, $request);
        if ($message === null) {
            abort(Response::HTTP_CONFLICT, 'Вы уже отправляли сообщение с подобным содержанием');
        }

        return $message;
    }

    public function createByDialog(Dialog $dialog, Request $request)
    {
        if ($dialog->isNotTookPartCurrentUser()) {
            throw new \LogicException('Вы не являетесь участником диалога');
        }

        $message = DialogMessageRepository::create($dialog, $request);

        return $message ? new DialogMessageResource($message) :
            abort(Response::HTTP_CONFLICT, 'Вы уже отправляли сообщение с подобным содержанием');
    }

    public function read(DialogMessage $message): DialogMessage
    {
        return $message->read();
    }
}
