<?php

namespace App\Models\Employee;

use Dba\ControlTime\Contracts\EmployeeContract;
use Illuminate\Database\Eloquent\Builder;

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

    protected static function boot(): void
    {
        parent::boot();

//        static::addGlobalScope('WorkConditions', function (Builder $builder) {
//            $builder->with(static::RELATION_WORK_CONDITIONS);
//        });
    }
}
