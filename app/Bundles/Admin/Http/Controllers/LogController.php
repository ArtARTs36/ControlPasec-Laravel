<?php

namespace App\Bundles\Admin\Http\Controllers;

use App\Bundles\Admin\Contracts\LogRepositoryInterface;
use App\Bundles\Admin\Http\Resources\ShowLog;
use App\Bundles\Admin\Services\LogService;
use App\Based\Contracts\Controller;
use App\Bundles\Admin\Http\Requests\SearchLog;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Collection;

final class LogController extends Controller
{
    private $service;

    public function __construct(LogService $service)
    {
        $this->service = $service;
    }

    public function index(LogRepositoryInterface $repository, int $page = 1): array
    {
        return $this->service->paginate($repository->page(LogService::DEFAULT_COUNT, $page), $page);
    }

    public function today(LogRepositoryInterface $repository): Collection
    {
        return $repository->today();
    }

    public function find(LogRepositoryInterface $repository, SearchLog $request): AnonymousResourceCollection
    {
        return ShowLog::collection($repository->findByWord($request->get('query')));
    }

    public function findByChannel(LogRepositoryInterface $repository, Request $request): AnonymousResourceCollection
    {
        return ShowLog::collection($repository->findByChannel($request->get('channel')));
    }
}
