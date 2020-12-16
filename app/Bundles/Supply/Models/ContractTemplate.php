<?php

namespace App\Bundles\Supply\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * @property int $id
 * @property string $name
 * @property string $contract_title
 */
class ContractTemplate extends Model
{
    public const FIELD_ID = 'id';
    public const FIELD_NAME = 'name';
    public const FIELD_TITLE = 'contract_title';

    protected $fillable = [
        self::FIELD_NAME,
        self::FIELD_TITLE,
    ];
}
