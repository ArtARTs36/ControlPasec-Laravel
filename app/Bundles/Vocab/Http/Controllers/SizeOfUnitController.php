<?php

namespace App\Bundles\Vocab\Http\Controllers;

use App\Bundles\Vocab\Http\Requests\StoreSizeOfUnit;
use App\Based\Contracts\Controller;
use App\Based\Http\Responses\ActionResponse;
use App\Bundles\Vocab\Models\SizeOfUnit;

class SizeOfUnitController extends Controller
{
    /**
     * @return ActionResponse
     */
    public function index()
    {
        return new ActionResponse(true, SizeOfUnit::all());
    }

    public function store(StoreSizeOfUnit $request): ActionResponse
    {
        return $this->createModelAndResponse($request, SizeOfUnit::class);
    }

    public function show(SizeOfUnit $sizeOfUnit): SizeOfUnit
    {
        return $sizeOfUnit;
    }

    /**
     * @param StoreSizeOfUnit $request
     * @param SizeOfUnit $sizeOfUnit
     * @return ActionResponse
     */
    public function update(StoreSizeOfUnit $request, SizeOfUnit $sizeOfUnit)
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
