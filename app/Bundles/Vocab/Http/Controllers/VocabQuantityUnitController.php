<?php

namespace App\Bundles\Vocab\Http\Controllers;

use App\Bundles\Vocab\Http\Requests\VocabQuantityUnitStore;
use App\Http\Controllers\Controller;
use App\Http\Responses\ActionResponse;
use App\Models\User\Permission;
use App\Bundles\Vocab\Models\VocabQuantityUnit;

final class VocabQuantityUnitController extends Controller
{
    public const PERMISSIONS = [
        'index' => Permission::VOCAB_QUANTITY_UNITS_LIST_VIEW,
        'show' => Permission::VOCAB_QUANTITY_UNITS_VIEW,
        'store' => Permission::VOCAB_QUANTITY_UNITS_CREATE,
        'update' => Permission::VOCAB_QUANTITY_UNITS_EDIT,
        'destroy' => Permission::VOCAB_QUANTITY_UNITS_DELETE,
    ];

    public function index(int $page = 0)
    {
        return VocabQuantityUnit::query()
            ->paginate(10, ['*'], 'VocabQuantityUnitsList', $page);
    }

    public function show(VocabQuantityUnit $vocabQuantityUnit): VocabQuantityUnit
    {
        return $vocabQuantityUnit;
    }

    public function store(VocabQuantityUnitStore $request)
    {
        return $this->createModelAndResponse($request, VocabQuantityUnit::class);
    }

    public function update(VocabQuantityUnitStore $request, VocabQuantityUnit $vocabQuantityUnit)
    {
        $vocabQuantityUnit->update($request->all());

        return new ActionResponse($vocabQuantityUnit->save(), $vocabQuantityUnit);
    }

    public function destroy(VocabQuantityUnit $vocabQuantityUnit)
    {
        return $this->deleteModelAndResponse($vocabQuantityUnit);
    }
}
