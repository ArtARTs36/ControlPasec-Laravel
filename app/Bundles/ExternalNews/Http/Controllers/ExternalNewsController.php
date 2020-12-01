<?php

namespace App\Bundles\ExternalNews\Http\Controllers;

use App\Bundles\ExternalNews\Http\Requests\UpdateRequest;
use App\Bundles\ExternalNews\Contracts\ExternalNewsRepository;
use App\Http\Controllers\Controller;
use App\Http\Responses\ActionResponse;
use App\Bundles\ExternalNews\Models\ExternalNews;
use App\Models\User\Permission;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ExternalNewsController extends Controller
{
    public const PERMISSIONS = [
        'index' => Permission::EXTERNAL_NEWS_LIST_VIEW,
        'show' => Permission::EXTERNAL_NEWS_VIEW,
        'update' => Permission::EXTERNAL_NEWS_EDIT,
        'store' => Permission::EXTERNAL_NEWS_CREATE,
        'destroy' => Permission::EXTERNAL_NEWS_DELETE,
    ];

    private $repository;

    public function __construct(ExternalNewsRepository $repository)
    {
        $this->repository = $repository;
    }

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
        return $this->repository->paginate($page);
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

    /**
     * @param ExternalNews $externalNews
     * @param UpdateRequest $request
     * @return ActionResponse
     */
    public function update(ExternalNews $externalNews, UpdateRequest $request): ActionResponse
    {
        return $this->updateModelAndResponse($request, $externalNews);
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

    /**
     * @return ActionResponse
     */
    public function truncate(): ActionResponse
    {
        ExternalNews::query()->truncate();

        return new ActionResponse(true);
    }
}
