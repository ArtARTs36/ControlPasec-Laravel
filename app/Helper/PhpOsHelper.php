<?php

namespace App\Helper;

class PhpOsHelper
{
    const UNKNOWN = 'unknown';
    const MAC = 'mac';

    public static function getOs(string $unknown = self::UNKNOWN): string
    {
        switch (PHP_OS) {
            case "Darwin":
                return self::MAC;
        }

        return $unknown;
    }
}
