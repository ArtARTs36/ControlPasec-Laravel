<?php

namespace App\Http\Controllers\Dialog;

use App\Http\Resource\DialogResource;
use App\Models\Dialog\Dialog;
use App\Http\Controllers\Controller;
use App\Repositories\DialogRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

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
        return DialogRepository::paginate($page);
    }

    /**
     * Получить диалоги пользователя
     * @param int $page
     * @return AnonymousResourceCollection
     */
    public function user(int $page = 1): AnonymousResourceCollection
    {
        return DialogRepository::findByUser(auth()->user(), $page);
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
