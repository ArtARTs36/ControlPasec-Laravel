<?php

namespace App\Based\Models;

use App\Based\ModelSupport\WithModelType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $type_id
 * @property ExternalSystem $type
 * @property int $model_type_id
 * @property ModelType $modelType
 * @property int $model_id
 * @property string $response
 */
class ExternalSystemExchange extends Model
{
    use WithModelType;

    public const FIELD_SYSTEM_ID = 'system_id';
    public const FIELD_MODEL_TYPE_ID = 'model_type_id';
    public const FIELD_MODEL_ID = 'model_id';
    public const FIELD_RESPONSE = 'response';

    protected $fillable = [
        self::FIELD_SYSTEM_ID,
        self::FIELD_MODEL_TYPE_ID,
        self::FIELD_MODEL_ID,
        self::FIELD_RESPONSE,
    ];

    private $model;

    /**
     * @codeCoverageIgnore
     */
    public function system(): BelongsTo
    {
        return $this->belongsTo(ExternalSystem::class);
    }

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
