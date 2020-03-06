<?php

namespace App\Models\Vocab;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int|null type
 * @property string nominative
 * @property string|null dative
 * @property string|null genitive
 * @property string|null instrumental
 * @property string|null prepositional
 *
 * @property string|null plural_nominative
 * @property string|null plural_dative
 * @property string|null plural_genitive
 * @property string|null plural_instrumental
 * @property string|null plural_prepositional
 */
final class VocabWord extends Model
{
    const TYPE_FAMILY = 0;
    const TYPE_NAME = 1;
    const TYPE_PATRONYMIC = 2;
    const TYPE_UNKNOWN = 3;
}
