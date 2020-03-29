<?php

namespace App\Services;

class ComposerParam
{
    private static $array = null;

    public static function getVersion(): ?string
    {
        return self::getArray()['version'] ?? null;
    }

    public static function getArray()
    {
        if (self::$array === null) {
            self::$array = json_decode(file_get_contents(self::getFilePath()), true);
        }

        return self::$array;
    }

    public static function save(): bool
    {
        if (self::$array === null) {
            return false;
        }

        return !file_put_contents(self::getFilePath(), json_encode(self::$array)) ? false : true;
    }

    public static function getFilePath(): string
    {
        return base_path('composer.json');
    }
}
