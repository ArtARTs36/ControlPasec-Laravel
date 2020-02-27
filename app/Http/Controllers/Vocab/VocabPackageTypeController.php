<?php

namespace App\Http\Controllers;

use App\Http\Responses\ActionResponse;
use App\Models\Vocab\VocabPackageType;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class VocabPackageTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return LengthAwarePaginator
     */
    public function index()
    {
        return VocabPackageType::paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param VocabPackageType $request
     * @return ActionResponse
     */
    public function store(VocabPackageType $request): ActionResponse
    {
        $type = new VocabPackageType();
        $type->name = $request->name;

        return new ActionResponse($type->save(), $type);
    }

    /**
     * Display the specified resource.
     *
     * @param VocabPackageType $vocabPackageType
     * @return VocabPackageType
     */
    public function show(VocabPackageType $vocabPackageType): VocabPackageType
    {
        return $vocabPackageType;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param VocabPackageType $vocabPackageType
     * @return ActionResponse
     */
    public function update(Request $request, VocabPackageType $vocabPackageType): ActionResponse
    {
        return new ActionResponse($vocabPackageType->update($request->all()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param VocabPackageType $vocabPackageType
     * @return ActionResponse
     */
    public function destroy(VocabPackageType $vocabPackageType): ActionResponse
    {
        return new ActionResponse($vocabPackageType->delete());
    }
}
