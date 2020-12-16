<?php

namespace App\Based\Services;

use App\Based\Models\ModelType;
use App\Based\Models\ExternalSystemExchange;
use App\Based\Models\ExternalSystem;
use Illuminate\Database\Eloquent\Model;

class ExternalExchanger
{
    public function create(Model $model, ExternalSystem $system, string $response): ExternalSystemExchange
    {
        $this->fillEntry($model, $sync = new ExternalSystemExchange(), $system, $response);
        $sync->save();

        return $sync;
    }

    protected function fillEntry(Model $model, ExternalSystemExchange $exchange, ExternalSystem $system, string $response): ExternalSystemExchange
    {
        return $exchange->fill([
            ExternalSystemExchange::FIELD_SYSTEM_ID => $system->id,
            ExternalSystemExchange::FIELD_MODEL_TYPE_ID => $this->getModelType($model)->id,
            ExternalSystemExchange::FIELD_MODEL_ID => $model->id,
            ExternalSystemExchange::FIELD_RESPONSE => $response,
        ]);
    }

    /**
     * @deprecated
     */
    private function getModelType(Model $model): ModelType
    {
        return ModelType::where('class', get_class($model))->first();
    }
}
