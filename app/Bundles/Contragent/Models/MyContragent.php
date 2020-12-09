<?php

namespace App\Bundles\Contragent\Models;

use App\Based\ModelSupport\WithFillOfRequest;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property int $contragent_id
 * @property mixed $signature
 */
final class MyContragent extends Model
{
    use WithFillOfRequest;

    public const FIELD_NAME = 'name';
    public const FIELD_CONTRAGENT_ID = 'contragent_id';
    public const FIELD_SIGNATURE = 'signature';

    protected $fillable = [
        self::FIELD_NAME,
        self::FIELD_CONTRAGENT_ID,
        self::FIELD_SIGNATURE,
    ];
}
