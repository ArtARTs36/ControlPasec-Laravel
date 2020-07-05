<?php

namespace App\Bundles\Vocab\Http\Controllers;

use App\Bundles\Vocab\Http\Requests\VocabWordStore;
use App\Http\Controllers\Controller;
use App\Models\User\Permission;
use App\Bundles\Vocab\Models\VocabWord;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class VocabWordController extends Controller
{
    public const PERMISSIONS = [
        'index' => Permission::VOCAB_WORDS_LIST_VIEW,
        'store' => Permission::VOCAB_WORDS_CREATE,
        'show' => Permission::VOCAB_WORD_VIEW,
        'update' => Permission::VOCAB_WORD_UPDATE,
    ];

    /**
     * @param int $page
     * @return LengthAwarePaginator
     */
    public function index(int $page = 1): LengthAwarePaginator
    {
        return VocabWord::query()
            ->paginate(10, ['*'], 'VocabWordsList', $page);
    }

    /**
     * @param  VocabWordStore  $request
     * @return VocabWord
     */
    public function store(VocabWordStore $request): VocabWord
    {
        return $this->createModel($request, VocabWord::class);
    }

    /**
     * @param VocabWord $vocabWord
     * @return VocabWord
     */
    public function show(VocabWord $vocabWord): VocabWord
    {
        return $vocabWord;
    }

    /**
     * @param VocabWordStore $request
     * @param VocabWord $vocabWord
     * @return \App\Http\Responses\ActionResponse
     */
    public function update(VocabWordStore $request, VocabWord $vocabWord)
    {
        return $this->updateModelAndResponse($request, $vocabWord);
    }
}
