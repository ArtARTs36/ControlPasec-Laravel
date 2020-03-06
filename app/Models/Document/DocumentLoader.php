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
 * @property DocumentExtension extension
 */
final class DocumentLoader extends Model
{
    /**
     * @return BelongsTo
     */
    public function extension(): BelongsTo
    {
        return $this->belongsTo(DocumentExtension::class);
    }
}
