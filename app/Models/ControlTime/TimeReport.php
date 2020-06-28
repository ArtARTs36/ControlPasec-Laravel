<?php

namespace App\Models\ControlTime;

use App\Models\Document\Document;
use App\Bundles\Employee\Models\Employee;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class TimeReport
 * @property int $id
 * @property int $employee_id
 * @property Employee $employee
 * @property string $start_date
 * @property string $end_date
 * @property int $times_quantity
 * @property int $document_id
 * @property Document $document
 */
class TimeReport extends Model
{
    public const RELATION_EMPLOYEE = 'employee';
    public const FIELD_EMPLOYEE_ID = 'employee_id';
    public const FIELD_START_DATE = 'start_date';
    public const FIELD_END_DATE = 'end_date';
    public const FIELD_TIMES_QUANTITY = 'times_quantity';
    public const FIELD_DOCUMENT_ID = 'document_id';

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(static::RELATION_EMPLOYEE, function (Builder $builder) {
            $builder->with(static::RELATION_EMPLOYEE);
        });
    }

    /**
     * @return BelongsTo
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * @return BelongsTo
     */
    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }
}
