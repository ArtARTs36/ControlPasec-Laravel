<?php

namespace App\Http\Controllers\Vocab;

use App\Http\Controllers\Controller;
use App\Http\Responses\ActionResponse;
use App\Models\Vocab\VocabGosStandard;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class VocabGosStandardController extends Controller
{
    /**
     * Отобразить список ГОСТов
     *
     * @param int $page
     * @return LengthAwarePaginator
     */
    public function index(int $page = 1)
    {
        return VocabGosStandard::latest('id')
            ->paginate(10, ['*'], 'VocabGosStandardsList', $page);
    }

    /**
     * Добавить ГОСТ
     *
     * @param Request $request
     * @return ActionResponse
     */
    public function store(Request $request): ActionResponse
    {
        $standard = new VocabGosStandard();
        $standard->fill($request->all());

        return new ActionResponse($standard->save(), $standard);
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
     * @param Request $request
     * @param VocabGosStandard $vocabGosStandard
     * @return ActionResponse
     */
    public function update(Request $request, VocabGosStandard $vocabGosStandard)
    {
        $vocabGosStandard->fill($request->all())
            ->save();

        return new ActionResponse(true, $vocabGosStandard);
    }

    /**
     * Удалить ГОСТ
     *
     * @param VocabGosStandard $vocabGosStandard
     * @return ActionResponse
     */
    public function destroy(VocabGosStandard $vocabGosStandard)
    {
        return new ActionResponse($vocabGosStandard->delete());
    }
}
