<?php

namespace App\Bundles\Contragent\Http\Controllers;

use App\Http\Requests\ContragentManagerRequest;
use App\Http\Responses\ActionResponse;
use App\Models\Contragent\ContragentManager;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ContragentManagerController extends Controller
{
    public function index(int $page = 1): LengthAwarePaginator
    {
        return ContragentManager::with('contragent')
            ->paginate(10, ['*'], 'ContragentsList', $page);
    }

    public function store(ContragentManagerRequest $request): ActionResponse
    {
        $manager = new ContragentManager();
        $manager->fill($request->toArray());

        return new ActionResponse($manager->save(), $manager);
    }

    public function show(ContragentManager $contragentManager): ContragentManager
    {
        return $contragentManager;
    }

    public function update(ContragentManagerRequest $request, ContragentManager $contragentManager): ActionResponse
    {
        return new ActionResponse($contragentManager->update($request->toArray()), $contragentManager);
    }

    public function destroy(ContragentManager $contragentManager): ActionResponse
    {
        return new ActionResponse($contragentManager->delete());
    }
}
