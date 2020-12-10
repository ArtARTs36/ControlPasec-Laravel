<?php

namespace App\Bundles\Vocab\Http\Controllers;

use App\Bundles\Vocab\Http\Requests\StoreVocabPackageType;
use App\Based\Http\Responses\ActionResponse;
use App\Bundles\User\Models\Permission;
use App\Bundles\Vocab\Models\VocabPackageType;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Based\Contracts\Controller;

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
     * @param StoreVocabPackageType $request
     * @return ActionResponse
     */
    public function store(StoreVocabPackageType $request): ActionResponse
    {
        $type = new VocabPackageType();
        $type->fillOfRequest($request);

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
     * @param StoreVocabPackageType $request
     * @param VocabPackageType $vocabPackageType
     * @return ActionResponse
     */
    public function update(StoreVocabPackageType $request, VocabPackageType $vocabPackageType): ActionResponse
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
