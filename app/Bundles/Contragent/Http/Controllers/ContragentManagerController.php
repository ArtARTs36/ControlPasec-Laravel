<?php

namespace App\Bundles\Contragent\Http\Controllers;

use App\Bundles\Contragent\Http\Requests\StoreManager;
use App\Based\Http\Responses\ActionResponse;
use App\Bundles\Contragent\Models\ContragentManager;
use App\Based\Contracts\Controller;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ContragentManagerController extends Controller
{
    /**
     * @tag ContragentManager
     */
    public function index(int $page = 1): LengthAwarePaginator
    {
        return ContragentManager::with('contragent')
            ->paginate(10, ['*'], 'ContragentsList', $page);
    }

    /**
     * @tag ContragentManager
     */
    public function store(StoreManager $request): ActionResponse
    {
        $manager = new ContragentManager();
        $manager->fill($request->toArray());

        return new ActionResponse($manager->save(), $manager);
    }

    /**
     * @tag ContragentManager
     */
    public function show(ContragentManager $contragentManager): ContragentManager
    {
        return $contragentManager;
    }

    /**
     * @tag ContragentManager
     */
    public function update(StoreManager $request, ContragentManager $contragentManager): ActionResponse
    {
        return new ActionResponse($contragentManager->update($request->toArray()), $contragentManager);
    }

    /**
     * @tag ContragentManager
     */
    public function destroy(ContragentManager $contragentManager): ActionResponse
    {
        return new ActionResponse($contragentManager->delete());
    }
}
