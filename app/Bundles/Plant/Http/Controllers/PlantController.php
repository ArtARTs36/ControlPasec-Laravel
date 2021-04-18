<?php

namespace App\Bundles\Plant\Http\Controllers;

use App\Based\Contracts\Controller;
use App\Bundles\Plant\Contracts\PlantRepository;
use App\Bundles\Plant\Http\Requests\UpdatePlant;
use App\Bundles\Plant\Http\Resources\PlantIndexShow;
use App\Bundles\Plant\Models\Plant;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class PlantController extends Controller
{
    private $repository;

    public function __construct(PlantRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(int $page = 1): AnonymousResourceCollection
    {
        return PlantIndexShow::collection($this->repository->paginate($page));
    }

    /**
     * @tag Plant
     */
    public function show(Plant $plant): JsonResource
    {
        return new JsonResource($plant);
    }

    /**
     * @tag Plant
     */
    public function update(Plant $plant, UpdatePlant $request): JsonResource
    {
        return new JsonResource($plant->updateOfRequest($request));
    }

    /**
     * @tag Plant
     */
    public function store(UpdatePlant $request): JsonResource
    {
        return new JsonResource((new Plant())->updateOfRequest($request));
    }

    public function showAll(): AnonymousResourceCollection
    {
        return JsonResource::collection($this->repository->all());
    }
}
