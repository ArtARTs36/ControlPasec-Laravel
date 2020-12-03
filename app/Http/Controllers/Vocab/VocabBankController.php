<?php

namespace App\Http\Controllers\Vocab;

use App\Http\Controllers\Controller;
use App\Http\Responses\ActionResponse;
use App\Bundles\User\Models\Permission;
use App\Models\Vocab\VocabBank;
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
     * Display a listing of the resource.
     *
     * @param int $page
     * @return LengthAwarePaginator
     */
    public function index(int $page = 1): LengthAwarePaginator
    {
        return VocabBank::latest('id')
            ->paginate(10, ['*'], 'VocabBanksList', $page);
    }

    /**
     * Добавления нового банка в справочник
     *
     * @param Request $request
     * @return ActionResponse
     */
    public function store(Request $request)
    {
        $bank = $this->createModel($request, VocabBank::class);

        return new ActionResponse($bank->exists, $bank);
    }

    /**
     * Отображение данных о банке
     *
     * @param VocabBank $vocabBank
     * @return VocabBank
     */
    public function show(VocabBank $vocabBank): VocabBank
    {
        return $vocabBank;
    }

    /**
     * Обновление данных о банке
     *
     * @param Request $request
     * @param VocabBank $vocabBank
     * @return ActionResponse
     */
    public function update(Request $request, VocabBank $vocabBank)
    {
        return $this->updateModelAndResponse($request, $vocabBank);
    }

    /**
     * Удаление банка из справочника
     *
     * @param VocabBank $vocabBank
     * @return ActionResponse
     * @throws \Exception
     */
    public function destroy(VocabBank $vocabBank): ActionResponse
    {
        return $this->deleteModelAndResponse($vocabBank);
    }
}
