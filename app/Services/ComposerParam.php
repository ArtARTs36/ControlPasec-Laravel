<?php

namespace App\Services;

class ComposerParam
{
    /** @var null|array */
    private static $array = null;

    public static function getVersion(): ?string
    {
        return static::getArray()['version'] ?? null;
    }

    public static function getArray()
    {
        if (static::$array === null) {
            static::$array = json_decode(file_get_contents(static::getFilePath()), true);
        }

        return static::$array;
    }

    public static function save(): bool
    {
        if (self::$array === null) {
            return false;
        }

        return !file_put_contents(static::getFilePath(), json_encode(static::$array)) ? false : true;
    }

    public static function getFilePath(): string
    {
        return base_path('composer.json');
    }
}
