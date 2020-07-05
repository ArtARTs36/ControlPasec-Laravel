<?php

namespace App\Bundles\Vocab\Http\Controllers;

use App\Bundles\Vocab\Http\Requests\VocabGosStandardStore;
use App\Http\Controllers\Controller;
use App\Http\Responses\ActionResponse;
use App\Models\User\Permission;
use App\Bundles\Vocab\Models\VocabGosStandard;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Class VocabGosStandardController
 * @package App\Bundles\Vocab\Http\Controllers
 */
final class VocabGosStandardController extends Controller
{
    public const PERMISSIONS = [
        'index' => Permission::VOCAB_GOS_STANDARD_LIST_VIEW,
        'store' => Permission::VOCAB_GOS_STANDARD_CREATE,
        'show' => Permission::VOCAB_GOS_STANDARD_VIEW,
        'update' => Permission::VOCAB_GOS_STANDARD_EDIT,
        'destroy' => Permission::VOCAB_GOS_STANDARD_DELETE,
    ];

    /**
     * Отобразить список ГОСТов
     *
     * @param int $page
     * @return LengthAwarePaginator
     */
    public function index(int $page = 1)
    {
        return VocabGosStandard::modify()
            ->latest('id')
            ->paginate(10, ['*'], 'VocabGosStandardsList', $page);
    }

    /**
     * Добавить ГОСТ
     *
     * @param VocabGosStandardStore $request
     * @return ActionResponse
     */
    public function store(VocabGosStandardStore $request): ActionResponse
    {
        return $this->createModelAndResponse($request, VocabGosStandard::class);
    }

    /**
     * Отобразить данные ГОСТа
     *
     * @param VocabGosStandard $vocabGosStandard
     * @return VocabGosStandard
     */
    public function show(VocabGosStandard $vocabGosStandard): VocabGosStandard
    {
        return $vocabGosStandard;
    }

    /**
     * Обновления данных ГОСТа
     *
     * @param VocabGosStandardStore $request
     * @param VocabGosStandard $vocabGosStandard
     * @return ActionResponse
     */
    public function update(VocabGosStandardStore $request, VocabGosStandard $vocabGosStandard)
    {
        return $this->updateModelAndResponse($request, $vocabGosStandard);
    }

    /**
     * Удалить ГОСТ
     *
     * @param VocabGosStandard $vocabGosStandard
     * @return ActionResponse
     * @throws \Exception
     */
    public function destroy(VocabGosStandard $vocabGosStandard)
    {
        return $this->deleteModelAndResponse($vocabGosStandard);
    }
}
