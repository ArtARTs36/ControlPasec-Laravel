<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use App\Models\News\ExternalNews;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class ExternalNewsController extends Controller
{
    /**
     * Отобразить новости из внешних источников
     *
     * @OA\Get(
     *     path="/external-news/page-{page}",
     *     description="External News: index Page",
     *     @OA\Response(response="default", description="View News"),
     *     @OA\Parameter(
     *      name="page",
     *      in="path",
     *      required=false,
     *      @OA\Schema(type="int")
     *     )
     * )
     *
     * @param int $page
     * @return LengthAwarePaginator
     */
    public function index($page = 1)
    {
        return ExternalNews::paginate(10, ['*'], null, $page);
    }

    /**
     * Отобразить несколько последних новостей из внешних источников
     *
     * @OA\Get(
     *     path="/external-news/chart/{count}",
     *     description="External News: index Page",
     *     @OA\Parameter(
     *      name="count",
     *      in="path",
     *      required=false,
     *      @OA\Schema(type="int")
     *     ),
     *     @OA\Response(response="default", description="View Latest News")
     * )
     *
     * @param int $count
     * @return LengthAwarePaginator
     */
    public function chart($count = 6)
    {
        return ExternalNews::with('source')->
            latest()->
            paginate($count);
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
     * @param  \App\ExternalNews  $externalNews
     * @return \Illuminate\Http\Response
     */
    public function show(ExternalNews $externalNews)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param ExternalNews $externalNews
     * @return void
     */
    public function update(Request $request, ExternalNews $externalNews)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ExternalNews  $externalNews
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExternalNews $externalNews)
    {
        //
    }
}
