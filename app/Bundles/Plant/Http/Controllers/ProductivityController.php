<?php

namespace App\Bundles\Plant\Http\Controllers;

use App\Based\Contracts\Controller;
use App\Bundles\Plant\Contracts\PlantRepository;
use App\Bundles\Plant\DTO\BringForecast;
use App\Bundles\Plant\Http\Requests\ShowHoneyForecast;
use App\Bundles\Plant\Http\Resources\ForecastResource;
use App\Bundles\Plant\Services\ForecastService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductivityController extends Controller
{
    protected $service;

    public function __construct(ForecastService $service)
    {
        $this->service = $service;
    }

    public function bring(ShowHoneyForecast $request, PlantRepository $plants): ForecastResource
    {
        return new ForecastResource($this->service->generateByPlant(
            $plants->find($request->input(ShowHoneyForecast::FIELD_PLANT_ID)),
            new BringForecast(
                Carbon::parse($request->input(ShowHoneyForecast::FIELD_DATE_START)),
                Carbon::parse($request->input(ShowHoneyForecast::FIELD_DATE_END)),
                $request->input(ShowHoneyForecast::FIELD_BEES),
                $request->input(ShowHoneyForecast::FIELD_SQUARE)
            )
        ));
    }
}
