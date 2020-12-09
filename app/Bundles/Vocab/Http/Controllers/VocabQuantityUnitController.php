<?php

namespace App\Bundles\Vocab\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Responses\ActionResponse;
use App\Bundles\User\Models\Permission;
use App\Bundles\Vocab\Models\VocabQuantityUnit;
use Illuminate\Http\Request;

class VocabQuantityUnitController extends Controller
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
        return VocabQuantityUnit::paginate(10, ['*'], 'VocabQuantityUnitsList', $page);
    }

    public function show(VocabQuantityUnit $vocabQuantityUnit): VocabQuantityUnit
    {
        return $vocabQuantityUnit;
    }

    public function store(Request $request)
    {
        $unit = new VocabQuantityUnit();
        $unit->fill($request->all());

        return new ActionResponse($unit->save(), $unit);
    }

    public function update(Request $request, VocabQuantityUnit $vocabQuantityUnit)
    {
        $vocabQuantityUnit->update($request->all());

        return new ActionResponse($vocabQuantityUnit->save(), $vocabQuantityUnit);
    }

    public function destroy(VocabQuantityUnit $vocabQuantityUnit)
    {
        return new ActionResponse($vocabQuantityUnit->delete());
    }
}
