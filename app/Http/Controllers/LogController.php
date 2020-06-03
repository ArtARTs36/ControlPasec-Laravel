<?php

namespace App\Http\Controllers;

use App\Support\Log\LogRepositoryInterface;
use App\Support\Log\LogService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * Class LogController
 * @package App\Http\Controllers
 */
class LogController extends Controller
{
    /**
     * @var LogService
     */
    private $service;

    /**
     * LogController constructor.
     * @param LogService $service
     */
    public function __construct(LogService $service)
    {
        $this->service = $service;
    }

    /**
     * @param LogRepositoryInterface $repository
     * @param int $page
     * @return array
     */
    public function index(LogRepositoryInterface $repository, int $page = 1)
    {
        return $this->service->paginate($repository->page(LogService::DEFAULT_COUNT, $page), $page);
    }

    /**
     * @param LogRepositoryInterface $repository
     * @return Collection
     */
    public function today(LogRepositoryInterface $repository): Collection
    {
        return $repository->today();
    }

    /**
     * @param LogRepositoryInterface $repository
     * @param Request $request
     * @return Collection
     */
    public function find(LogRepositoryInterface $repository, Request $request): Collection
    {
        return $repository->findByWord($request->get('query'));
    }
}
