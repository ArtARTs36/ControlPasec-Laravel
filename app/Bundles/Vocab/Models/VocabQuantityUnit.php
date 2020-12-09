<?php

namespace App\Bundles\Vocab\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $short_name
 * @property string $name_en
 * @property string $short_name_en
 * @property int $okei
 */
final class VocabQuantityUnit extends Model
{
    protected $fillable = [
        'name', 'short_name', 'name_en', 'short_name_en', 'okei'
    ];
}
