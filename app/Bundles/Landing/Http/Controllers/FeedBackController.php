<?php

namespace App\Bundles\Landing\Http\Controllers;

use App\Bundles\Landing\Http\Resources\FeedBackResource;
use App\Bundles\Landing\Repositories\FeedBackRepository;
use App\Bundles\Landing\Events\FeedBackCreated;
use App\Based\Contracts\Controller;
use App\Bundles\Landing\Http\Requests\StoreFeedBack;
use App\Based\Http\Responses\ActionResponse;
use App\Bundles\Landing\Models\FeedBack;
use App\Bundles\Landing\Services\FeedBackCreator;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class FeedBackController extends Controller
{
    private $repository;

    public function __construct(FeedBackRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @tag Landing
     * @return LengthAwarePaginator<FeedBackResource>
     */
    public function index(int $page = 1): LengthAwarePaginator
    {
        return $this->repository->paginate($page);
    }

    /**
     * @tag Landing
     */
    public function show(FeedBack $feedback): FeedBackResource
    {
        return new FeedBackResource($feedback);
    }

    /**
     * @tag Landing
     */
    public function store(StoreFeedBack $request, FeedBackCreator $creator): ActionResponse
    {
        $creator->fromRequest($request);

        return new ActionResponse(true);
    }
}
