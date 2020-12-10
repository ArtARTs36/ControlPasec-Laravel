<?php

namespace App\Bundles\Landing\Http\Controllers;

use App\Bundles\Landing\Repositories\FeedBackRepository;
use App\Bundles\Landing\Events\FeedBackCreated;
use App\Based\Contracts\Controller;
use App\Bundles\Landing\Http\Requests\StoreFeedBack;
use App\Http\Responses\ActionResponse;
use App\Bundles\Landing\Models\FeedBack;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Resources\Json\JsonResource;

final class FeedBackController extends Controller
{
    private $repository;

    public function __construct(FeedBackRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(int $page = 1): LengthAwarePaginator
    {
        return $this->repository->paginate($page);
    }

    public function show(FeedBack $feedback): JsonResource
    {
        return new JsonResource($feedback);
    }

    public function store(StoreFeedBack $request): ActionResponse
    {
        $feedback = new FeedBack();

        $feedback->fillOfRequest($request);
        $feedback->ip = $request->getClientIp();

        $feedback->save();

        event(new FeedBackCreated($feedback));

        return new ActionResponse(true);
    }
}
