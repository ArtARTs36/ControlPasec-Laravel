<?php

namespace App\Install;

use App\Services\Go\GoProgramExecutor;

class AppPostInstall
{
    public static function apply()
    {
        self::checkGoPrograms();
    }

    public static function checkGoPrograms()
    {
        $dir = GoProgramExecutor::GO_ROOT_DIR;
        $folders = array_filter(array_values(array_diff(scandir($dir), ['.', '..'])), function ($folder) use ($dir) {
            return is_dir($dir. DIRECTORY_SEPARATOR. $folder);
        });

        foreach ($folders as $folder) {
            $pathToData = $dir . DIRECTORY_SEPARATOR . $folder. '/data';
            if (!file_exists($pathToData) || !is_dir($pathToData)) {
                mkdir($pathToData);
            }
        }

        dump('Go-Programs: Папки для данных проверены');
    }
}
