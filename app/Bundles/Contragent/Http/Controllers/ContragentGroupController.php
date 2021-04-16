<?php

namespace App\Bundles\Contragent\Http\Controllers;

use App\Based\Contracts\Controller;
use App\Bundles\Contragent\Http\Requests\UpdateContragentGroup;
use App\Based\Http\Responses\ActionResponse;
use App\Bundles\Contragent\Http\Resources\ContragentGroupResource;
use App\Bundles\Contragent\Models\Contragent;
use App\Bundles\Contragent\Models\ContragentGroup;
use App\Bundles\Contragent\Services\ContragentGroupService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Resources\Json\JsonResource;

class ContragentGroupController extends Controller
{
    protected $service;

    public function __construct(ContragentGroupService $service)
    {
        $this->service = $service;
    }

    /**
     * Получить список групп контрагентов
     * @tag ContragentGroup
     */
    public function index(): LengthAwarePaginator
    {
        return ContragentGroup::modify()
            ->with(ContragentGroup::RELATION_CONTRAGENTS)
            ->paginate();
    }

    /**
     * @tag ContragentGroup
     */
    public function store(UpdateContragentGroup $request): JsonResource
    {
        return new JsonResource($this->service->create(
            $request->input(ContragentGroup::FIELD_NAME),
            $request->input(UpdateContragentGroup::FIELD_CONTRAGENTS, [])
        ));
    }

    /**
     * @tag ContragentGroup
     */
    public function show(ContragentGroup $contragentGroup): ContragentGroupResource
    {
        return new ContragentGroupResource($contragentGroup->load('contragents'));
    }

    /**
     * @tag ContragentGroup
     */
    public function update(UpdateContragentGroup $request, ContragentGroup $contragentGroup)
    {
        $contragentGroup->contragents()->sync(
            $request->get(UpdateContragentGroup::FIELD_CONTRAGENTS, [])
        );

        return $this->updateModelAndResponse($request, $contragentGroup);
    }

    /**
     * @throws \Exception
     * @tag ContragentGroup
     */
    public function destroy(ContragentGroup $contragentGroup): ActionResponse
    {
        return new ActionResponse($contragentGroup->delete());
    }

    /**
     * @tag ContragentGroup
     */
    public function detach(ContragentGroup $group, Contragent $contragent): ActionResponse
    {
        return new ActionResponse((bool) $group->contragents()->detach($contragent->id));
    }

    /**
     * @tag ContragentGroup
     */
    public function detachAll(ContragentGroup $group): ActionResponse
    {
        return new ActionResponse((bool) $group->contragents()->detach());
    }
}
