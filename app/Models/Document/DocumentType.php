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
    // Счет на оплату
    public const SCORE_FOR_PAYMENT_ID = 1;
    public const SCORES_FOR_PAYMENTS_ID = 2;
    public const TORG_12_ID = 3;
    public const QUALITY_CERTIFICATE_ID = 4;
    public const MANY_TORG_12_ID = 5;
    public const ONE_T_FORM_ID = 6;
    public const ROLE_SYSTEM_ID = 7;
    public const TIME_REPORT_ID = 8;
    public const SZV_TD_ID = 9;

    /**
     * @codeCoverageIgnore
     */
    public function loader(): BelongsTo
    {
        return $this->belongsTo(DocumentLoader::class);
    }
}
