<?php

namespace App\Bundles\Vocab\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int|null $type
 * @property string $nominative
 * @property string|null $dative
 * @property string|null $genitive
 * @property string|null $instrumental
 * @property string|null $prepositional
 *
 * @property string|null $plural_nominative
 * @property string|null $plural_dative
 * @property string|null $plural_genitive
 * @property string|null $plural_instrumental
 * @property string|null $plural_prepositional
 */
final class VocabWord extends Model
{
    public const TYPE_FAMILY = 0;
    public const TYPE_NAME = 1;
    public const TYPE_PATRONYMIC = 2;
    public const TYPE_UNKNOWN = 3;

    public const FIELD_NOMINATIVE = 'nominative';
    public const FIELD_DATIVE = 'dative';
    public const FIELD_GENITIVE = 'genitive';
    public const FIELD_PREPOSITIONAL = 'prepositional';
    public const FIELD_INSTRUMENTAL = 'instrumental';

    public const FIELD_PLURAL_NOMINATIVE = 'plural_nominative';
    public const FIELD_PLURAL_DATIVE = 'plural_dative';
    public const FIELD_PLURAL_GENITIVE = 'plural_genitive';
    public const FIELD_PLURAL_PREPOSITIONAL = 'plural_prepositional';
    public const FIELD_PLURAL_INSTRUMENTAL = 'plural_instrumental';

    protected $fillable = [
        self::FIELD_NOMINATIVE,
        self::FIELD_DATIVE,
        self::FIELD_GENITIVE,
        self::FIELD_PREPOSITIONAL,
        self::FIELD_INSTRUMENTAL,
        self::FIELD_PLURAL_NOMINATIVE,
        self::FIELD_PLURAL_DATIVE,
        self::FIELD_PLURAL_GENITIVE,
        self::FIELD_PLURAL_PREPOSITIONAL,
        self::FIELD_PLURAL_INSTRUMENTAL,
    ];

    public static function getSingularFields(): array
    {
        return [
            self::FIELD_NOMINATIVE,
            self::FIELD_DATIVE,
            self::FIELD_GENITIVE,
            self::FIELD_PREPOSITIONAL,
            self::FIELD_INSTRUMENTAL,
        ];
    }

    public static function getPluralFields(): array
    {
        return [
            self::FIELD_PLURAL_NOMINATIVE,
            self::FIELD_PLURAL_DATIVE,
            self::FIELD_PLURAL_GENITIVE,
            self::FIELD_PLURAL_PREPOSITIONAL,
            self::FIELD_PLURAL_INSTRUMENTAL,
        ];
    }
}
