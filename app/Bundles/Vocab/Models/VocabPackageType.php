<?php

namespace App\Bundles\Vocab\Models;

use App\Based\ModelSupport\WithFillOfRequest;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 */
final class VocabPackageType extends Model
{
    use WithFillOfRequest;

    public const FIELD_ID = 'id';
    public const FIELD_NAME = 'name';

    protected $fillable = [
        self::FIELD_ID,
        self::FIELD_NAME,
    ];
}
