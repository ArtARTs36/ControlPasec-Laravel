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
 * @property Collection|WorkCondition[] $workConditions
 */
class Employee extends EmployeeContract
{
    const FIELD_FAMILY = 'family';
    const FIELD_NAME = 'name';
    const FIELD_PATRONYMIC = 'patronymic';
    const FIELD_HIRED_DATE = 'hired_date';

    protected $fillable = [
        self::FIELD_FAMILY,
        self::FIELD_NAME,
        self::FIELD_PATRONYMIC,
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
