<?php

namespace App\Bundles\Document\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 */
final class DocumentExtension extends Model
{
    public const XLS = 'xls';
    public const XLSX = 'xlsx';
    public const PDF = 'pdf';
    public const DOCX = 'docx';

    public const FIELD_NAME = 'name';
}
