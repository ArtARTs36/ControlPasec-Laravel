<?php

namespace App\Bundles\Landing\Http\Controllers;

use App\Bundles\Landing\Repositories\FeedBackRepository;
use App\Bundles\Landing\Events\FeedBackCreated;
use App\Http\Controllers\Controller;
use App\Bundles\Landing\Http\Requests\StoreFeedBack;
use App\Http\Responses\ActionResponse;
use App\Bundles\Landing\Models\FeedBack;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

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

    public function store(StoreFeedBack $request): ActionResponse
    {
        $feedback = new FeedBack();

        $feedback->people_title = $request->people_title;
        $feedback->people_email = $request->people_email;
        $feedback->people_phone = $request->people_phone;
        $feedback->message = $request->message;
        $feedback->ip = $request->getClientIp();

        $feedback->save();

        event(new FeedBackCreated($feedback));

        return new ActionResponse(true);
    }
}
