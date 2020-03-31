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

class DialogMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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
    public function store(DialogMessageRequest $request): DialogMessage
    {
        $toUser = User::find($request->to_user_id);

        $dialog = DialogRepository::getOrCreate($toUser);

        return DialogMessageRepository::create($dialog, $request);
    }

    public function createByDialog(Dialog $dialog, Request $request)
    {
        if ($dialog->isNotTookPartCurrentUser()) {
            throw new \LogicException('Вы не являетесь участником диалога');
        }

        $message = DialogMessageRepository::create($dialog, $request);

        return new DialogMessageResource($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DialogMessage  $dialogMessage
     * @return \Illuminate\Http\Response
     */
    public function show(DialogMessage $dialogMessage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DialogMessage  $dialogMessage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DialogMessage $dialogMessage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DialogMessage  $dialogMessage
     * @return \Illuminate\Http\Response
     */
    public function destroy(DialogMessage $dialogMessage)
    {
        //
    }

    public function read(DialogMessage $message)
    {
        return $message->read();
    }
}
