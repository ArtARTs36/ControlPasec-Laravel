<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExternalNews\ExternalNewsRequest;
use App\Http\Responses\ActionResponse;
use App\Models\News\ExternalNews;
use App\Models\News\ExternalNewsSource;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class ExternalNewsSourceController extends Controller
{
    /**
     * Отобразить внешние источники новостей
     *
     * @param int $page
     * @return LengthAwarePaginator
     */
    public function index(int $page = 1)
    {
        return ExternalNewsSource::paginate(10, ['*'], 'ExternalNewsSourcesList', $page);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ExternalNewsRequest  $request
     * @return ExternalNews
     */
    public function store(ExternalNewsRequest $request): ExternalNews
    {
        return ExternalNews::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param ExternalNewsSource $externalNewsSource
     * @return ExternalNewsSource
     */
    public function show(ExternalNewsSource $externalNewsSource): ExternalNewsSource
    {
        return $externalNewsSource;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ExternalNewsRequest  $request
     * @param  ExternalNewsSource  $externalNewsSource
     * @return ActionResponse
     */
    public function update(ExternalNewsRequest $request, ExternalNewsSource $externalNewsSource)
    {
        return new ActionResponse($externalNewsSource->update($request->all()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ExternalNewsSource  $externalNewsSource
     * @return ActionResponse
     */
    public function destroy(ExternalNewsSource $externalNewsSource)
    {
        return new ActionResponse($externalNewsSource->delete() > 0);
    }
}
