<?php

namespace App\Bundles\ExternalNews\Http\Controllers;

use App\Bundles\ExternalNews\Http\Requests\ExternalNewsSourceRequest;
use App\Based\Contracts\Controller;
use App\Based\Http\Responses\ActionResponse;
use App\Bundles\ExternalNews\Models\ExternalNewsSource;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ExternalNewsSourceController extends Controller
{
    /**
     * Отобразить внешние источники новостей
     * @tag ExternalNewsSource
     */
    public function index(int $page = 1)
    {
        return ExternalNewsSource::query()
            ->paginate(10, ['*'], 'ExternalNewsSourcesList', $page);
    }

    /**
     * Добавить источник внешних новостей
     * @tag ExternalNewsSource
     */
    public function store(ExternalNewsSourceRequest $request): ExternalNewsSource
    {
        return $this->createModel($request, ExternalNewsSource::class);
    }

    /**
     * Показать источник внешних новостей
     * @tag ExternalNewsSource
     */
    public function show(ExternalNewsSource $externalNewsSource): ExternalNewsSource
    {
        return $externalNewsSource;
    }

    /**
     * Обновить источник внешних новостей
     * @tag ExternalNewsSource
     */
    public function update(ExternalNewsSourceRequest $request, ExternalNewsSource $externalNewsSource)
    {
        return new ActionResponse($externalNewsSource->update($request->all()));
    }

    /**
     * Удалить источник
     * @tag ExternalNewsSource
     */
    public function destroy(ExternalNewsSource $externalNewsSource)
    {
        return new ActionResponse($externalNewsSource->delete() > 0);
    }
}
