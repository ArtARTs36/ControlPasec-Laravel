<?php

namespace App\Bundles\Plant\Http\Controllers;

use App\Based\Contracts\Controller;
use App\Bundles\Plant\Contracts\PlantRepository;
use App\Bundles\Plant\Models\Plant;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Resources\Json\JsonResource;

class PlantController extends Controller
{
    private $repository;

    public function __construct(PlantRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return LengthAwarePaginator<Plant>
     */
    public function index(int $page = 1): LengthAwarePaginator
    {
        return $this->repository->paginate($page);
    }

    /**
     * @tag Plant
     */
    public function show(Plant $plant): JsonResource
    {
        return new JsonResource($plant);
    }
}
