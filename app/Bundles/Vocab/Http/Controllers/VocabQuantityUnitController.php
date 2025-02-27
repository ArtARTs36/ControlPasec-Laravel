<?php

namespace App\Bundles\Vocab\Http\Controllers;

use App\Based\Contracts\Controller;
use App\Based\Http\Responses\ActionResponse;
use App\Bundles\User\Models\Permission;
use App\Bundles\Vocab\Models\VocabQuantityUnit;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
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

    /**
     * @tag VocabQuantityUnit
     * @return LengthAwarePaginator<VocabQuantityUnit>
     */
    public function index(int $page = 0): LengthAwarePaginator
    {
        return VocabQuantityUnit::query()
            ->paginate(10, ['*'], 'VocabQuantityUnitsList', $page);
    }

    /**
     * @tag VocabQuantityUnit
     */
    public function show(VocabQuantityUnit $vocabQuantityUnit): VocabQuantityUnit
    {
        return $vocabQuantityUnit;
    }

    /**
     * @tag VocabQuantityUnit
     */
    public function store(Request $request)
    {
        $unit = new VocabQuantityUnit();
        $unit->fill($request->all());

        return new ActionResponse($unit->save(), $unit);
    }

    /**
     * @tag VocabQuantityUnit
     */
    public function update(Request $request, VocabQuantityUnit $vocabQuantityUnit)
    {
        $vocabQuantityUnit->update($request->all());

        return new ActionResponse($vocabQuantityUnit->save(), $vocabQuantityUnit);
    }

    /**
     * @tag VocabQuantityUnit
     */
    public function destroy(VocabQuantityUnit $vocabQuantityUnit)
    {
        return new ActionResponse($vocabQuantityUnit->delete());
    }
}
