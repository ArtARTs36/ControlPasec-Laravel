<?php

namespace App\Models\Document;

use Illuminate\Database\Eloquent\Model;

/**
 * Class DocumentExtension
 *
 * @property int $id
 * @property string $name
 */
final class DocumentExtension extends Model
{
    public const XLS = 'xls';
    public const XLSX = 'xlsx';
    public const PDF = 'pdf';
}
