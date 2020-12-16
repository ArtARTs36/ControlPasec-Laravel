<?php

namespace App\Bundles\Vocab\Http\Controllers;

use App\Based\Contracts\Controller;
use App\Based\Http\Responses\ActionResponse;
use App\Bundles\User\Models\Permission;
use App\Bundles\Vocab\Models\VocabBank;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class VocabBankController extends Controller
{
    public const PERMISSIONS = [
        'index' => Permission::VOCAB_BANKS_LIST_VIEW,
        'store' => Permission::VOCAB_BANKS_LIST_VIEW,
        'show' => Permission::VOCAB_BANKS_VIEW,
        'update' => Permission::VOCAB_BANKS_EDIT,
        'destroy' => Permission::VOCAB_BANKS_DELETE,
    ];

    /**
     * Получить список банков
     * @tag VocabBank
     * @return LengthAwarePaginator<VocabBank>
     */
    public function index(int $page = 1): LengthAwarePaginator
    {
        return VocabBank::latest('id')
            ->paginate(10, ['*'], 'VocabBanksList', $page);
    }

    /**
     * Добавления нового банка в справочник
     * @tag VocabBank
     */
    public function store(Request $request)
    {
        $bank = $this->createModel($request, VocabBank::class);

        return new ActionResponse($bank->exists, $bank);
    }

    /**
     * Отображение данных о банке
     * @tag VocabBank
     */
    public function show(VocabBank $vocabBank): VocabBank
    {
        return $vocabBank;
    }

    /**
     * Обновление данных о банке
     * @tag VocabBank
     */
    public function update(Request $request, VocabBank $vocabBank)
    {
        return $this->updateModelAndResponse($request, $vocabBank);
    }

    /**
     * Удаление банка из справочника
     * @tag VocabBank
     */
    public function destroy(VocabBank $vocabBank): ActionResponse
    {
        return $this->deleteModelAndResponse($vocabBank);
    }
}
