<?php

namespace App\Bundles\Plant\Http\Resources;

use App\Bundles\Plant\DTO\Forecast;
use ArtARTs36\LaravelWeather\Models\Day;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Forecast
 */
class ForecastResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'weight' => $this->weight,
            'days' => array_map(function (Day $day) {
                return [
                    'date' => $day->date->format('Y-m-d'),
                    'temperature' => $day->temperature,
                ];
            }, $this->days),
            'start' => $this->start->format('Y-m-d'),
            'end' => $this->end->format('Y-m-d'),
            'request' => [
                'start' => $this->request->start->format('Y-m-d'),
                'end' => $this->request->end->format('Y-m-d'),
                'square' => $this->request->square,
                'bees' => $this->request->bees,
            ],
            'plant' => $this->plant,
        ];
    }
}
