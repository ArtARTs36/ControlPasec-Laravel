<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use App\Http\Responses\ActionResponse;
use App\Models\News\ExternalNews;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class ExternalNewsController extends Controller
{
    /**
     * Отобразить новости из внешних источников
     *
     * @OA\Get(
     *     path="/api/external-news/page-{page}",
     *     description="External News: index Page",
     *     tags={"External News"},
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
    public function index(int $page = 1)
    {
        return ExternalNews::with('source')
            ->paginate(10, ['*'], 'ExternalNews', $page);
    }

    /**
     * Отобразить несколько последних новостей из внешних источников
     *
     * @OA\Get(
     *     path="/api/external-news/chart/{count}",
     *     description="External News: index Page",
     *     tags={"External News"},
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
    public function chart(int $count = 6): LengthAwarePaginator
    {
        return ExternalNews::with('source')
            ->latest()
            ->paginate($count);
    }

    /**
     * Display the specified resource.
     *
     * @param ExternalNews $externalNews
     * @return ExternalNews
     */
    public function show(ExternalNews $externalNews)
    {
        return $externalNews;
    }

    public function update(ExternalNews $externalNews, Request $request): ActionResponse
    {
        return new ActionResponse(
            $externalNews->update($request->only(['title', 'description'])) > 0,
            $externalNews
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ExternalNews $externalNews
     * @return ActionResponse
     */
    public function destroy(ExternalNews $externalNews): ActionResponse
    {
        return new ActionResponse($externalNews->delete() > 0);
    }
}
