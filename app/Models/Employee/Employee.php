<?php

namespace App\Models\Employee;

use Dba\ControlTime\Contracts\EmployeeContract;
use Dba\ControlTime\Models\WorkCondition;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class Employee
 * @property int $id
 * @property string $family
 * @property string $name
 * @property string $patronymic
 * @property string $hired_date
 * @property string $holiday
 * @property string $insurance_number
 * @property Collection|WorkCondition[] $workConditions
 */
class Employee extends EmployeeContract
{
    public const FIELD_FAMILY = 'family';
    public const FIELD_NAME = 'name';
    public const FIELD_PATRONYMIC = 'patronymic';
    public const FIELD_HIRED_DATE = 'hired_date';
    public const FIELD_HOLIDAY = 'holiday';
    public const FIELD_INSURANCE_NUMBER = 'insurance_number';

    protected $fillable = [
        self::FIELD_FAMILY,
        self::FIELD_NAME,
        self::FIELD_PATRONYMIC,
        self::FIELD_HIRED_DATE,
        self::FIELD_HOLIDAY,
        self::FIELD_INSURANCE_NUMBER,
    ];

    public function getFullName(): string
    {
        return implode(' ', [
            $this->family,
            $this->name,
            $this->patronymic,
        ]);
    }
}
