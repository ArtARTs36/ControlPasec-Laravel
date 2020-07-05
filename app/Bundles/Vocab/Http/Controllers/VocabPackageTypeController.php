<?php

namespace App\Bundles\Vocab\Http\Controllers;

use App\Bundles\Vocab\Http\Requests\VocabPackageTypeStore;
use App\Http\Responses\ActionResponse;
use App\Models\User\Permission;
use App\Bundles\Vocab\Models\VocabPackageType;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Http\Controllers\Controller;

/**
 * Class VocabPackageTypeController
 * @package App\Http\Controllers\Vocab
 */
final class VocabPackageTypeController extends Controller
{
    public const PERMISSIONS = [
        'index' => Permission::VOCAB_PACKAGE_TYPES_LIST_VIEW,
        'store' => Permission::VOCAB_PACKAGE_TYPES_CREATE,
        'show' => Permission::VOCAB_PACKAGE_TYPES_VIEW,
        'update' => Permission::VOCAB_PACKAGE_TYPES_EDIT,
        'destroy' => Permission::VOCAB_PACKAGE_TYPES_DELETE,
    ];

    /**
     * @return LengthAwarePaginator
     */
    public function index()
    {
        return VocabPackageType::modify()->paginate();
    }

    /**
     * @param VocabPackageTypeStore $request
     * @return ActionResponse
     */
    public function store(VocabPackageTypeStore $request): ActionResponse
    {
        return $this->createModelAndResponse($request, VocabPackageType::class);
    }

    /**
     * @param VocabPackageType $vocabPackageType
     * @return VocabPackageType
     */
    public function show(VocabPackageType $vocabPackageType): VocabPackageType
    {
        return $vocabPackageType;
    }

    /**
     * @param VocabPackageTypeStore $request
     * @param VocabPackageType $vocabPackageType
     * @return ActionResponse
     */
    public function update(VocabPackageTypeStore $request, VocabPackageType $vocabPackageType): ActionResponse
    {
        return $this->updateModelAndResponse($request, $vocabPackageType);
    }

    /**
     * @param VocabPackageType $vocabPackageType
     * @return ActionResponse
     * @throws \Exception
     */
    public function destroy(VocabPackageType $vocabPackageType): ActionResponse
    {
        return $this->deleteModelAndResponse($vocabPackageType);
    }
}
