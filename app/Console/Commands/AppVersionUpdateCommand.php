<?php

namespace App\Console\Commands;

use App\Helper\FileHelper;
use App\Services\ComposerParam;
use Illuminate\Console\Command;
use App\Support\AbstractAppVersion;

final class AppVersionUpdateCommand extends Command
{
    protected $signature = 'app-version:update';

    protected $description = 'App Version update';

    private $installedVersions = [];

    public function handle()
    {
        $this->getInstalledVersions();

        foreach ($this->getActualVersions() as $version) {
            $this->executeUpdate($version);
        }
    }

    /**
     * Получить список установленных версий
     */
    private function getInstalledVersions(): void
    {
        $filePath = $this->getInstalledVersionsPath();
        if (!file_exists($filePath)) {
            file_put_contents($filePath, json_encode([]));
        } else {
            $this->installedVersions = json_decode(
                file_get_contents($filePath),
                true
            ) ?? [];
        }
    }

    /**
     * Получить путь к файлу, который содержит список установленных версий
     * @return string
     */
    private function getInstalledVersionsPath(): string
    {
        return base_path('app-versions/') . 'installed_versions.json';
    }

    /**
     * Выполнить переход на новую версию
     * @param AbstractAppVersion $version
     */
    private function executeUpdate(AbstractAppVersion $version): void
    {
        $version->migrate();
        $this->pushInstalledVersion($version);

        $this->comment('Приложение обновлено до версии '. $version::getTitle());
    }

    /**
     * Получить список актуальных версий
     * @return array|null
     */
    private function getActualVersions(): ?array
    {
        $classes = $this->getVersionsClasses();

        $versions = [];
        $currentVersion = ComposerParam::getVersion();
        foreach ($classes as $class) {
            if (!$this->isVersionInstalled($class::getTitle()) && $class::getTitle() < $currentVersion) {
                $versions[] = new $class();
            }
        }

        return $versions;
    }

    /**
     * Получить классы версий
     * @return array|null
     */
    private function getVersionsClasses(): ?array
    {
        $files = FileHelper::findPhpClass(base_path('app-versions'));
        $classesNames = [];
        foreach ($files as $file) {
            $split = explode("/", $file);
            $fileName = end($split);

            $className = "AppVersions\\". str_replace('.php', '', $fileName);
            $classesNames[] = $className;
        }

        return $classesNames;
    }

    /**
     * Положить версию в список установленных
     * @param AbstractAppVersion $version
     */
    private function pushInstalledVersion(AbstractAppVersion $version): void
    {
        $this->installedVersions[] = $version->getTitle();
    }

    /**
     * Установлена ли версия
     * @param string $versionTitle
     * @return bool
     */
    private function isVersionInstalled(string $versionTitle): bool
    {
        return in_array($versionTitle, $this->installedVersions);
    }

    /**
     * Деструктор
     * Сохраняем список установленных версий в файл
     */
    public function __destruct()
    {
        file_put_contents($this->getInstalledVersionsPath(), json_encode($this->installedVersions));
    }
}
