<?php

namespace App\Models\Vocab;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SizeOfUnit
 *
 * @property string name
 * @property string short_name
 * @property string name_en
 * @property string short_name_en
 */
class SizeOfUnit extends Model
{
    protected $fillable = [
        'name', 'short_name', 'name_en', 'short_name_en'
    ];
}
