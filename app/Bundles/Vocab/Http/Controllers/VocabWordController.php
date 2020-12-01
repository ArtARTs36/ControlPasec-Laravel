<?php

namespace App\Bundles\Vocab\Http\Controllers;

use App\Bundles\Vocab\Http\Requests\StoreVocabWord;
use App\Models\User\Permission;
use App\Bundles\Vocab\Models\VocabWord;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class VocabWordController
{
    public const PERMISSIONS = [
        'index' => Permission::VOCAB_WORDS_LIST_VIEW,
        'store' => Permission::VOCAB_WORDS_CREATE,
        'show' => Permission::VOCAB_WORD_VIEW,
        'update' => Permission::VOCAB_WORD_UPDATE,
    ];

    public function index(int $page = 1): LengthAwarePaginator
    {
        return VocabWord::paginate(10, ['*'], 'VocabWordsList', $page);
    }

    public function store(StoreVocabWord $request): VocabWord
    {
        $word = new VocabWord();
        $word->fill($request->toArray());
        $word->save();

        return $word;
    }

    public function show(VocabWord $vocabWord): VocabWord
    {
        return $vocabWord;
    }

    public function update(Request $request, VocabWord $vocabWord)
    {
        $vocabWord->setRawAttributes($request->all());

        return $vocabWord;
    }
}
