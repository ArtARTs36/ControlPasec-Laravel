<?php

namespace App\Models\Sync;

use App\Models\ModelType;
use App\Based\ModelSupport\WithModelType;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SyncWithExternalSystem
 * @property int $id
 * @property int $type_id
 * @property SyncWithExternalSystemType $type
 * @property int $model_type_id
 * @property ModelType $modelType
 * @property int $model_id
 * @property string $response
 */
class SyncWithExternalSystem extends Model
{
    use WithModelType;

    protected $fillable = [
        'type_id', 'model_type_id', 'model_id', 'response',
    ];

    private $model;

    public function getModel(): Model
    {
        if ($this->model !== null) {
            return $this->model;
        }

        if (!$this->relationLoaded('modelType')) {
            $this->load('modelType');
        }

        $class = $this->modelType->class;

        return $this->model = $class::find($this->model_id);
    }

    public function getComparedData(): array
    {
        return [
            'currentData' => $this->getModel(),
            'givenData' => $this->response,
        ];
    }
}
