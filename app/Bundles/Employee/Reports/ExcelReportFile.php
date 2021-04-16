<?php

namespace App\Bundles\Employee\Reports;

use App\Bundles\Document\Support\XlsxRender;
use ArtARTs36\ControlTime\Contracts\Report;
use ArtARTs36\ControlTime\Contracts\ReportFile;
use ArtARTs36\ControlTime\Reports\Infrastructure\FileObjects\AbstractReportFile;
use ArtARTs36\FileStorageContracts\FileAlias;
use ArtARTs36\FileStorageContracts\FileStorage;
use ArtARTs36\LaravelFileStorage\Models\Section;

class ExcelReportFile extends AbstractReportFile implements ReportFile
{
    protected $data;

    protected $template;

    public function __construct(Report $report, string $title, array $data, string $template)
    {
        parent::__construct($report, $title);

        $this->data = $data;
        $this->template = $template;
    }

    public function save(FileStorage $storage, Section $section): FileAlias
    {
        $render = new XlsxRender();

        $path = $render->render('documents/otchet.xlsx', $this->template, $this->data);

        return $storage->save($path, $this->getTitle(), false, $section);
    }
}
