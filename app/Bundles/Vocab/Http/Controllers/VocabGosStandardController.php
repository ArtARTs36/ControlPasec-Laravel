<?php

namespace App\Bundles\Vocab\Http\Controllers;

use App\Bundles\Vocab\Http\Requests\StoreGosStandard;
use App\Based\Contracts\Controller;
use App\Http\Responses\ActionResponse;
use App\Bundles\User\Models\Permission;
use App\Bundles\Vocab\Models\VocabGosStandard;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VocabGosStandardController extends Controller
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
     */
    public function store(StoreGosStandard $request): JsonResource
    {
        return new JsonResource((new VocabGosStandard())->fillOfRequest($request));
    }

    /**
     * Отобразить данные ГОСТа
     */
    public function show(VocabGosStandard $vocabGosStandard): JsonResource
    {
        return new JsonResource($vocabGosStandard);
    }

    /**
     * Обновления данных ГОСТа
     */
    public function update(StoreGosStandard $request, VocabGosStandard $vocabGosStandard)
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
