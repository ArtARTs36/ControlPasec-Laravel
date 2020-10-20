<?php

namespace App\Bundles\Contract\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * Модель "Шаблон договора"
 *
 * @property int $id
 * @property string $name
 * @property string $contract_title
 */
class ContractTemplate extends Model
{
    public const FIELD_NAME = 'name';
    public const FIELD_TITLE = 'contract_title';

    protected $fillable = [
        self::FIELD_NAME,
        self::FIELD_TITLE,
    ];
}
