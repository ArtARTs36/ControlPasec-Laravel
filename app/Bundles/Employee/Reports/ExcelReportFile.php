<?php

namespace App\Bundles\Employee\Reports;

use App\Bundles\Document\Support\XlsxRender;
use App\Services\Document\DocTemplateLoader\PhpExcelTemplateLoader;
use ArtARTs36\ControlTime\Contracts\Report;
use ArtARTs36\ControlTime\Contracts\ReportFile;
use ArtARTs36\ControlTime\Reports\Infrastructure\FileObjects\AbstractReportFile;
use ArtARTs36\FileStorageContracts\FileAlias;
use ArtARTs36\FileStorageContracts\FileStorage;
use ArtARTs36\LaravelFileStorage\Models\Section;
use Illuminate\Support\Str;

class ExcelReportFile extends AbstractReportFile implements ReportFile
{
    protected $data;

    protected $template;

    protected $loader;

    public function __construct(
        Report $report,
        string $title,
        array $data,
        string $template,
        PhpExcelTemplateLoader $loader
    ) {
        parent::__construct($report, $title);

        $this->data = $data;
        $this->template = $template;
        $this->loader = $loader;
    }

    public function save(FileStorage $storage, Section $section): FileAlias
    {
        $path = storage_path(Str::random() . '.xlsx');

        $this->loader->makeRaw($this->template, $path, $this->data);

        return $storage->save($path, $this->getTitle(), false, $section);
    }
}
