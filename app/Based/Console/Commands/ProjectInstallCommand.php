<?php

namespace App\Based\Console\Commands;

use App\Based\GoBridge\Executor;
use App\Based\Support\OS;
use App\Based\Support\FileHelper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ProjectInstallCommand extends Command
{
    protected $signature = 'project-install {--no-dompdf-fonts}';

    protected $description = 'Project install';

    public function handle(): bool
    {
        if ($this->isLocked()) {
            dump('Установка заблокирована!');

            return false;
        }

        file_put_contents(base_path('install.lock'), 'locked');

        shell_exec('composer dump-autoload --optimize');

        $this->checkGoPrograms();
        $this->checkExistsFileDocumentsMap();
        $this->checkEnvFile();
        $this->checkTmpFolderFilesNames();

        if ($this->option('no-dompdf-fonts')) {
            $this->warn('Without Dompdf fonts');
        } else {
            $this->call(CompileFontFromDompdfCommand::class);
        }

        Artisan::call('jwt:secret');
        Artisan::call('migrate');
        Artisan::call('db:seed');
        Artisan::call('cache:clear');

        return true;
    }

    private function isLocked(): bool
    {
        return file_exists(base_path('install.lock'));
    }

    private function checkTmpFolderFilesNames(): void
    {
        $path = views_path(env('DOCUMENT_TMP_NAMES_DIR'));
        if (!file_exists($path)) {
            mkdir($path);
        }

        dump('Папка для сохранения временных файлов документов проверена');
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
        FileHelper::createFileIfNotExists(base_path(env('DOCUMENT_SAVE_MAP')), "1");

        dump('Проверен мап-файл для сохранения документов');
    }

    private function checkGoPrograms(): void
    {
        $dir = Executor::GO_ROOT_DIR;
        $elementsOfDir = array_diff(scandir($dir), ['.', '..']);

        $folders = array_filter(array_values($elementsOfDir), function ($folder) use ($dir) {
            return is_dir($dir. DIRECTORY_SEPARATOR. $folder);
        });

        foreach ($folders as $goProgramName) {
            $folder = $dir . DIRECTORY_SEPARATOR . $goProgramName;
            $pathToData = $folder. '/data';
            if (!file_exists($pathToData)) {
                mkdir($pathToData);
            }

            $this->selectBinFileForGoProgram($goProgramName, $folder);
        }

        foreach (array_diff($elementsOfDir, $folders) as $file) {
            chmod($dir. DIRECTORY_SEPARATOR . $file, 0755);
        }

        dump('Go-Programs: Папки для данных проверены');
    }

    private function selectBinFileForGoProgram(string $name, string $path): bool
    {
        $os = OS::get();
        $pathToBuild = $path . '/builds/'. $name . '_'. $os;
        if (!file_exists($pathToBuild)) {
            return false;
        }

        $pathToBinFolder = $path . '/bin/';

        if (!file_exists($pathToBinFolder)) {
            mkdir($pathToBinFolder);
        }

        $pathToBin = $pathToBinFolder . $name;
        if (!file_exists($pathToBin)) {
            copy($pathToBuild, $pathToBin);
        }

        chmod($pathToBin, 0755);

        return true;
    }
}
