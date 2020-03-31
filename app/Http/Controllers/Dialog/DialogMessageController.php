<?php

namespace App\Http\Controllers\Dialog;

use App\Http\Controllers\Controller;
use App\Http\Requests\DialogMessageRequest;
use App\Models\Dialog\DialogMessage;
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

        $message = new DialogMessage();
        $message->from_user_id = auth()->user()->id;
        $message->to_user_id = $toUser->id;
        $message->dialog_id = $dialog->id;
        $message->is_read = false;
        $message->text = $request->text;
        $message->save();

        return $message;
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
