<?php

namespace App\Bundles\Contragent\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Bundles\Contragent\Http\Requests\UpdateContragentGroup;
use App\Http\Responses\ActionResponse;
use App\Models\Contragent;
use App\Models\Contragent\ContragentGroup;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ContragentGroupController extends Controller
{
    /**
     * Получить список групп контрагентов
     *
     * @return LengthAwarePaginator
     */
    public function index(): LengthAwarePaginator
    {
        return ContragentGroup::modify()
            ->with(ContragentGroup::RELATION_CONTRAGENTS)
            ->paginate();
    }

    /**
     * @param UpdateContragentGroup $request
     * @return ActionResponse
     */
    public function store(UpdateContragentGroup $request)
    {
        $group = $this->createModel($request, ContragentGroup::class);
        $group->contragents()->sync(
            $request->get(UpdateContragentGroup::FIELD_CONTRAGENTS, [])
        );

        return new ActionResponse($group->exists, $group);
    }

    /**
     * @param ContragentGroup $contragentGroup
     * @return ContragentGroup
     */
    public function show(ContragentGroup $contragentGroup): ContragentGroup
    {
        return $contragentGroup->load('contragents');
    }

    /**
     * @param UpdateContragentGroup $request
     * @param ContragentGroup $contragentGroup
     * @return ActionResponse
     */
    public function update(UpdateContragentGroup $request, ContragentGroup $contragentGroup)
    {
        $contragentGroup->contragents()->sync(
            $request->get(UpdateContragentGroup::FIELD_CONTRAGENTS, [])
        );

        return $this->updateModelAndResponse($request, $contragentGroup);
    }

    /**
     * @param ContragentGroup $contragentGroup
     * @return ActionResponse
     */
    public function destroy(ContragentGroup $contragentGroup): ActionResponse
    {
        return new ActionResponse($contragentGroup->delete());
    }

    /**
     * @param ContragentGroup $group
     * @param Contragent $contragent
     * @return ActionResponse
     */
    public function detach(ContragentGroup $group, Contragent $contragent): ActionResponse
    {
        return new ActionResponse((bool) $group->contragents()->detach($contragent->id));
    }

    /**
     * @param ContragentGroup $group
     * @return ActionResponse
     */
    public function detachAll(ContragentGroup $group): ActionResponse
    {
        return new ActionResponse((bool) $group->contragents()->detach());
    }
}
