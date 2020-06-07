<?php

namespace App\Http\Controllers\Vocab;

use App\Http\Controllers\Controller;
use App\Http\Responses\ActionResponse;
use App\Models\Vocab\SizeOfUnit;
use Illuminate\Http\Request;

class SizeOfUnitController extends Controller
{
    /**
     * @return ActionResponse
     */
    public function index()
    {
        return new ActionResponse(true, SizeOfUnit::all());
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return ActionResponse
     */
    public function store(Request $request): ActionResponse
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
     * @param \Illuminate\Http\Request $request
     * @param SizeOfUnit $sizeOfUnit
     * @return ActionResponse
     */
    public function update(Request $request, SizeOfUnit $sizeOfUnit)
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
