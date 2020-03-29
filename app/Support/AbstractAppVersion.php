<?php

namespace App\Support;

use Illuminate\Support\Facades\Artisan;

abstract class AbstractAppVersion
{
    abstract public function migrate();

    public static function getTitle()
    {
        $className = static::class;
        $version = str_replace('AppVersion', '', class_basename($className));
        $title = '';

        for ($i = 0; $i < 5; $i += 2) {
            $number = substr($version, $i, 2);
            $title .= ($number < 10) ? (int) $number : $number;
            if ($i < 4) {
                $title .= '.';
            }
        }

        return $title;
    }

    protected function migrateDataBase()
    {
        Artisan::call('migrate');
    }
}
