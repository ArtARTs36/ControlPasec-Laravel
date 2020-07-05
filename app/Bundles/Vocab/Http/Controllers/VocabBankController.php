<?php

namespace App\Bundles\Vocab\Http\Controllers;

use App\Bundles\Vocab\Http\Requests\VocabBankStore;
use App\Http\Controllers\Controller;
use App\Http\Responses\ActionResponse;
use App\Models\User\Permission;
use App\Bundles\Vocab\Models\VocabBank;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

/**
 * Class VocabBankController
 * @package App\Bundles\Vocab\Http\Controllers
 */
final class VocabBankController extends Controller
{
    public const PERMISSIONS = [
        'index' => Permission::VOCAB_BANKS_LIST_VIEW,
        'store' => Permission::VOCAB_BANKS_CREATE,
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
        return VocabBank::query()
            ->latest('id')
            ->paginate(10, ['*'], 'VocabBanksList', $page);
    }

    /**
     * Добавления нового банка в справочник
     *
     * @param VocabBankStore $request
     * @return ActionResponse
     */
    public function store(VocabBankStore $request)
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
    public function update(VocabBankStore $request, VocabBank $vocabBank)
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
