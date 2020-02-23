<?php

namespace App\Http\Controllers\Vocab;

use App\Http\Controllers\Controller;
use App\Http\Responses\ActionResponse;
use App\Models\Vocab\VocabBank;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class VocabBankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param int $page
     * @return LengthAwarePaginator
     */
    public function index($page = 1)
    {
        return VocabBank::latest('id')->paginate(10, ['*'], null, $page);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return ActionResponse
     */
    public function store(Request $request)
    {
        $bank = new VocabBank();
        $bank->fill($request->all());

        return new ActionResponse($bank->save(), $bank);
    }

    /**
     * Display the specified resource.
     *
     * @param VocabBank $vocabBank
     * @return VocabBank
     */
    public function show(VocabBank $vocabBank): VocabBank
    {
        return $vocabBank;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param VocabBank $vocabBank
     * @return ActionResponse
     */
    public function update(Request $request, VocabBank $vocabBank)
    {
        return new ActionResponse($vocabBank->update($request->all()), $vocabBank);
    }

    /**
     * Удаление банка из справочника
     *
     * @param VocabBank $vocabBank
     * @return ActionResponse
     */
    public function destroy(VocabBank $vocabBank): ActionResponse
    {
        return new ActionResponse($vocabBank->delete());
    }
}
