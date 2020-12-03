<?php

namespace App\Based\Support\Archiver;

class ArchiverFactory
{
    const EXTENSIONS_CLASSES = [
        ArchiverInterface::EXTENSION_ZIP => Zipper::class,
    ];

    public static function get(int $extension): ArchiverInterface
    {
        $class = self::EXTENSIONS_CLASSES[$extension];

        return new $class();
    }
}
