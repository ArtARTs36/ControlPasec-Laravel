<?php

namespace App\Bundles\Employee\Models;

use ArtARTs36\EmployeeInterfaces\Employee\EmployeeInterface;
use ArtARTs36\EmployeeInterfaces\WorkCondition\WorkConditionInterface;
use ArtARTs36\EmployeeInterfaces\WorkCondition\WorkConditionSettersAndGetters;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $position
 * @property double $rate
 * @property int $employee_id
 * @property int $amount_hour
 * @property int $amount_month
 * @property EmployeeInterface $employee
 * @property Carbon $hire_date
 * @property Carbon $fire_date
 * @property int $tab_number
 */
class WorkCondition extends Model implements WorkConditionInterface
{
    use WorkConditionSettersAndGetters;

    public const FIELD_POSITION = 'position';
    public const FIELD_RATE = 'rate';
    public const FIELD_EMPLOYEE_ID = 'employee_id';
    public const FIELD_AMOUNT_HOUR = 'amount_hour';
    public const FIELD_TAB_NUMBER = 'tab_number';
    public const FIELD_FIRE_DATE = 'fire_date';
    public const FIELD_HIRE_DATE = 'hire_date';

    protected $fillable = [
        self::FIELD_POSITION,
        self::FIELD_RATE,
        self::FIELD_EMPLOYEE_ID,
        self::FIELD_AMOUNT_HOUR,
        self::FIELD_TAB_NUMBER,
        self::FIELD_FIRE_DATE,
        self::FIELD_HIRE_DATE,
    ];

    protected $table = 'work_conditions';

    /**
     * @codeCoverageIgnore
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
