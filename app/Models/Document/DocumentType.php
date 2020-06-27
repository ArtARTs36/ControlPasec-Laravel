<?php

namespace App\Models\Document;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class DocumentType
 *
 * @property int $id
 * @property string $name
 * @property string $title
 * @property string $template
 * @property int $loader_id
 * @property DocumentLoader $loader
 *
 * @mixin Builder
 */
final class DocumentType extends Model
{
    const SCORE_FOR_PAYMENT_ID = 1;
    const SCORES_FOR_PAYMENTS_ID = 2;
    const TORG_12_ID = 3;
    const QUALITY_CERTIFICATE_ID = 4;
    const MANY_TORG_12_ID = 5;
    const ONE_T_FORM_ID = 6;
    const ROLE_SYSTEM_ID = 7;
    const TIME_REPORT_ID = 8;
    const SZV_TD_ID = 9;

    /**
     * @return BelongsTo
     */
    public function loader(): BelongsTo
    {
        return $this->belongsTo(DocumentLoader::class);
    }
}
