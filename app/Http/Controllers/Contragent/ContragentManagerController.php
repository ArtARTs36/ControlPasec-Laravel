<?php

namespace App\Http\Controllers\Contragent;

use App\Http\Requests\ContragentManagerRequest;
use App\Http\Responses\ActionResponse;
use App\Models\Contragent\ContragentManager;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ContragentManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param int $page
     * @return LengthAwarePaginator
     */
    public function index(int $page = 1): LengthAwarePaginator
    {
        return ContragentManager::with('contragent')
            ->paginate(10, ['*'], 'ContragentsList', $page);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ContragentManagerRequest $request
     * @return ActionResponse
     */
    public function store(ContragentManagerRequest $request): ActionResponse
    {
        $manager = new ContragentManager();
        $manager->fill($request->toArray());

        return new ActionResponse($manager->save(), $manager);
    }

    /**
     * Display the specified resource.
     *
     * @param ContragentManager $contragentManager
     * @return ContragentManager
     */
    public function show(ContragentManager $contragentManager): ContragentManager
    {
        return $contragentManager;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ContragentManagerRequest $request
     * @param ContragentManager $contragentManager
     * @return ActionResponse
     */
    public function update(ContragentManagerRequest $request, ContragentManager $contragentManager): ActionResponse
    {
        return new ActionResponse($contragentManager->update($request->toArray()), $contragentManager);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ContragentManager $contragentManager
     * @return ActionResponse
     */
    public function destroy(ContragentManager $contragentManager): ActionResponse
    {
        return new ActionResponse($contragentManager->delete());
    }
}
