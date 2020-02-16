<?php

namespace App\Models\Document;

use Illuminate\Database\Eloquent\Model;

/**
 * Class DocumentExtension
 *
 * @property int id
 * @property string name
 */
class DocumentExtension extends Model
{
    const XLS = "xls";
    const XLSX = "xlsx";
    const PDF = "pdf";
}
