<?php

namespace App\Based\Support;

class OS
{
    public const UNKNOWN = 'unknown';
    public const MAC = 'mac';
    public const WINDOWS = 'windows';
    public const LINUX = 'linux';

    public static function get(string $unknown = self::UNKNOWN): string
    {
        switch (PHP_OS) {
            case "Darwin":
                return self::MAC;
            case "Linux":
                return self::LINUX;
            case "Windows":
                return self::WINDOWS;
        }

        return $unknown;
    }
}
