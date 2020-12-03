<?php

namespace App\Bundles\User\Http\Controllers;

use App\Bundles\User\Http\Resources\DialogsListResource;
use App\Bundles\User\Repositories\DialogRepository;
use App\Bundles\User\Services\DialogService;
use App\Bundles\User\Http\Resources\DialogResource;
use App\Bundles\User\Models\Dialog;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

final class DialogController extends Controller
{
    private $repository;

    private $service;

    public function __construct(DialogRepository $repository, DialogService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }


    public function index(int $page = 1): LengthAwarePaginator
    {
        return $this->repository->paginate($page);
    }

    /**
     * Получить диалоги пользователя
     */
    public function user(int $page = 1): AnonymousResourceCollection
    {
        return DialogsListResource::collection($this->repository->findByUser(auth()->user(), $page));
    }

    public function show(Dialog $dialog, int $page = 1): DialogResource
    {
        return new DialogResource(...$this->service->show($dialog, $page));
    }

    public function destroy(Dialog $dialog): Dialog
    {
        return $dialog->hide(Auth::user());
    }
}
