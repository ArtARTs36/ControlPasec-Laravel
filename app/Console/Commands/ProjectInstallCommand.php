<?php

namespace App\Console\Commands;

use App\Helper\FileHelper;
use App\Services\Go\GoProgramExecutor;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ProjectInstallCommand extends Command
{
    protected $signature = 'project-install';

    protected $description = 'Project install';

    public function handle()
    {
        $this->checkGoPrograms();
        $this->checkExistsFileDocumentsMap();
        $this->checkEnvFile();

        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

    private function checkEnvFile(): void
    {
        if (!file_exists(base_path('.env'))) {
            copy('.env.example', '.env');
        }

        dump('Файл .env проверен');
    }

    private function checkExistsFileDocumentsMap(): void
    {
        FileHelper::createFileIfNotExists(base_path(env('DOCUMENT_SAVE_MAP')), 1);

        dump('Проверен мап-файл для сохранения документов');
    }

    private function checkGoPrograms(): void
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
