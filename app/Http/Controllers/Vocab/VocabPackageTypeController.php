<?php

namespace App\Http\Controllers\Vocab;

use App\Http\Responses\ActionResponse;
use App\Models\User\Permission;
use App\Models\Vocab\VocabPackageType;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VocabPackageTypeController extends Controller
{
    public const PERMISSIONS = [
        'index' => Permission::VOCAB_PACKAGE_TYPES_LIST_VIEW,
        'store' => Permission::VOCAB_PACKAGE_TYPES_CREATE,
        'show' => Permission::VOCAB_PACKAGE_TYPES_VIEW,
        'update' => Permission::VOCAB_PACKAGE_TYPES_EDIT,
        'destroy' => Permission::VOCAB_PACKAGE_TYPES_DELETE,
    ];

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
