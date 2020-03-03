<?php

namespace App\Models\TextDataParser;

use App\Models\ModelType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * Class TextDataParser
 *
 * @property int id
 * @property string title
 * @property string template
 * @property string preparer
 * @property string class
 * @property string image
 * @property-read ModelType[] $models
 *
 * @mixin Builder
 */
class TextDataParserComponent extends Model
{
    const FIRST_COMPONENT_ID = 1;

    public function models()
    {
        return $this->belongsToMany(
            ModelType::class,
            'text_data_parser_components_model',
            'component_id',
            'model_id'
        );
    }
}
