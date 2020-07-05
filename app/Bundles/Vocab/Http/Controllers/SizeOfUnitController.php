<?php

namespace App\Bundles\Vocab\Http\Controllers;

use App\Bundles\Vocab\Http\Requests\SizeOfUnitStore;
use App\Http\Controllers\Controller;
use App\Http\Responses\ActionResponse;
use App\Bundles\Vocab\Models\SizeOfUnit;

/**
 * Class SizeOfUnitController
 * @package App\Bundles\Vocab\Http\Controllers
 */
final class SizeOfUnitController extends Controller
{
    /**
     * @return ActionResponse
     */
    public function index(): ActionResponse
    {
        return new ActionResponse(true, SizeOfUnit::all());
    }

    /**
     * @param SizeOfUnitStore $request
     * @return ActionResponse
     */
    public function store(SizeOfUnitStore $request): ActionResponse
    {
        return $this->createModelAndResponse($request, SizeOfUnit::class);
    }

    /**
     * @param SizeOfUnit $sizeOfUnit
     * @return SizeOfUnit
     */
    public function show(SizeOfUnit $sizeOfUnit): SizeOfUnit
    {
        return $sizeOfUnit;
    }

    /**
     * @param SizeOfUnitStore $request
     * @param SizeOfUnit $sizeOfUnit
     * @return ActionResponse
     */
    public function update(SizeOfUnitStore $request, SizeOfUnit $sizeOfUnit)
    {
        return $this->updateModelAndResponse($request, $sizeOfUnit);
    }

    /**
     * @param SizeOfUnit $sizeOfUnit
     * @return ActionResponse
     * @throws \Exception
     */
    public function destroy(SizeOfUnit $sizeOfUnit)
    {
        return $this->deleteModelAndResponse($sizeOfUnit);
    }
}
