<?php

namespace App\Bundles\Vocab\Http\Controllers;

use App\Bundles\Vocab\Http\Requests\StoreSizeOfUnit;
use App\Based\Contracts\Controller;
use App\Based\Http\Responses\ActionResponse;
use App\Bundles\Vocab\Models\SizeOfUnit;

class SizeOfUnitController extends Controller
{
    /**
     * @tag SizeOfUnit
     */
    public function index()
    {
        return new ActionResponse(true, SizeOfUnit::all());
    }

    /**
     * @tag SizeOfUnit
     */
    public function store(StoreSizeOfUnit $request): ActionResponse
    {
        return $this->createModelAndResponse($request, SizeOfUnit::class);
    }

    /**
     * @tag SizeOfUnit
     */
    public function show(SizeOfUnit $sizeOfUnit): SizeOfUnit
    {
        return $sizeOfUnit;
    }

    /**
     * @tag SizeOfUnit
     */
    public function update(StoreSizeOfUnit $request, SizeOfUnit $sizeOfUnit)
    {
        return $this->updateModelAndResponse($request, $sizeOfUnit);
    }

    /**
     * @tag SizeOfUnit
     * @param SizeOfUnit $sizeOfUnit
     * @return ActionResponse
     * @throws \Exception
     */
    public function destroy(SizeOfUnit $sizeOfUnit)
    {
        return $this->deleteModelAndResponse($sizeOfUnit);
    }
}
