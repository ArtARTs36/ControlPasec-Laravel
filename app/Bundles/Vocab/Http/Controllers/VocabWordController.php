<?php

namespace App\Bundles\Vocab\Http\Controllers;

use App\Bundles\Vocab\Http\Requests\StoreVocabWord;
use App\Bundles\User\Models\Permission;
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

    /**
     * Получить список слов
     * @tag VocabWord
     * @return LengthAwarePaginator<VocabWord>
     */
    public function index(int $page = 1): LengthAwarePaginator
    {
        return VocabWord::paginate(10, ['*'], 'VocabWordsList', $page);
    }

    /**
     * Добавить новое слово
     * @tag VocabWord
     */
    public function store(StoreVocabWord $request): VocabWord
    {
        $word = new VocabWord();
        $word->fill($request->toArray());
        $word->save();

        return $word;
    }

    /**
     * @tag VocabWord
     */
    public function show(VocabWord $vocabWord): VocabWord
    {
        return $vocabWord;
    }

    /**
     * @tag VocabWord
     */
    public function update(StoreVocabWord $request, VocabWord $vocabWord)
    {
        $vocabWord->setRawAttributes($request->all());

        return $vocabWord;
    }

    /**
     * @tag VocabWord
     */
    public function destroy(VocabWord $word)
    {
        return $word->delete();
    }
}
