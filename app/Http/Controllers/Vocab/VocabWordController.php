<?php

namespace App\Http\Controllers\Vocab;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vocab\VocabWordRequest;
use App\Models\Vocab\VocabWord;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class VocabWordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param int $page
     * @return LengthAwarePaginator
     */
    public function index(int $page = 1): LengthAwarePaginator
    {
        return VocabWord::paginate(10, ['*'], 'VocabWordsList', $page);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  VocabWordRequest  $request
     * @return VocabWord
     */
    public function store(VocabWordRequest $request): VocabWord
    {
        $word = new VocabWord();
        $word->fill($request->toArray());
        $word->save();

        return $word;
    }

    /**
     * Display the specified resource.
     *
     * @param VocabWord $vocabWord
     * @return VocabWord
     */
    public function show(VocabWord $vocabWord): VocabWord
    {
        return $vocabWord;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param VocabWord $vocabWord
     * @return VocabWord
     */
    public function update(Request $request, VocabWord $vocabWord)
    {
        $vocabWord->setRawAttributes($request->all());

        return $vocabWord;
    }
}
