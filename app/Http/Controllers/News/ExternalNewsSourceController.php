<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
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
    public function index($page)
    {
        return ExternalNewsSource::paginate(10, ['*'], null, $page);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ExternalNewsSource  $externalNewsSource
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExternalNewsSource $externalNewsSource)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ExternalNewsSource  $externalNewsSource
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExternalNewsSource $externalNewsSource)
    {
        //
    }
}
