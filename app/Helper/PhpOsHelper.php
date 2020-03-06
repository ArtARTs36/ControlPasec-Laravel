<?php

namespace App\Helper;

class PhpOsHelper
{
    const UNKNOWN = 'unknown';
    const MAC = 'mac';
    const WINDOWS = 'windows';
    const LINUX = 'linux';

    public static function getOs(string $unknown = self::UNKNOWN): string
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
