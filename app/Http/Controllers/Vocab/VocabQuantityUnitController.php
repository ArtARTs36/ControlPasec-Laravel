<?php

namespace App\Http\Controllers\Vocab;

use App\Http\Controllers\Controller;
use App\Http\Responses\ActionResponse;
use App\Models\Vocab\VocabQuantityUnit;
use Illuminate\Http\Request;

class VocabQuantityUnitController extends Controller
{
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
