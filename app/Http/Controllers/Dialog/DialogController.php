<?php

namespace App\Http\Controllers\Dialog;

use App\Http\Resource\DialogResource;
use App\Models\Dialog\Dialog;
use App\Http\Controllers\Controller;
use App\Repositories\DialogRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class DialogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param int $page
     * @return LengthAwarePaginator
     */
    public function index(int $page = 1): LengthAwarePaginator
    {
        return Dialog::paginate(10, ['*'], null, $page);
    }

    /**
     * Получить диалоги пользователя
     * @param int $page
     * @return LengthAwarePaginator
     */
    public function user(int $page = 1): LengthAwarePaginator
    {
        return DialogRepository::findByCurrentUser($page);
    }

    /**
     * Display the specified resource.
     *
     * @param Dialog $dialog
     * @return DialogResource
     */
    public function show(Dialog $dialog): DialogResource
    {
        return new DialogResource($dialog);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Dialog $dialog
     * @return Dialog
     */
    public function destroy(Dialog $dialog): Dialog
    {
        return $dialog->hideForCurrentUser();
    }
}
