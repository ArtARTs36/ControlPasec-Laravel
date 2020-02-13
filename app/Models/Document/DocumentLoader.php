<?php

namespace App\Models\Document;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class DocumentLoader
 *
 * @property int id
 * @property string name
 * @property int extension_id
 */
class DocumentLoader extends Model
{
    /**
     * @return BelongsTo|DocumentExtension
     */
    public function extension()
    {
        return $this->belongsTo(DocumentExtension::class);
    }
}
