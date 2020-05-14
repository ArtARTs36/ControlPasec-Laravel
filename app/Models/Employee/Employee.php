<?php

namespace App\Models\Employee;

use Dba\ControlTime\Contracts\EmployeeContract;

/**
 * Class Employee
 * @property int $id
 * @property string $family
 * @property string $name
 * @property string $patronymic
 */
class Employee extends EmployeeContract
{
    const FIELD_FAMILY = 'family';
    const FIELD_NAME = 'name';
    const FIELD_PATRONYMIC = 'patronymic';

    protected $fillable = [
        self::FIELD_FAMILY,
        self::FIELD_NAME,
        self::FIELD_PATRONYMIC,
    ];
}
