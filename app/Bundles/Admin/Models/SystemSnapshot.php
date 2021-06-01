<?php

namespace App\Bundles\Admin\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $disk_name
 * @property int $disk_available
 * @property int $disk_used
 * @property int $disk_total
 * @property float $cpu_user_usage
 * @property float $cpu_system_usage
 * @property float $cpu_idle
 * @property \DateTimeInterface $created_at
 */
class SystemSnapshot extends Model
{
    public const FIELD_ID = 'id';
    public const FIELD_DISK_NAME = 'disk_name';
    public const FIELD_DISK_AVAILABLE = 'disk_available';
    public const FIELD_DISK_USED = 'disk_used';
    public const FIELD_DISK_TOTAL = 'disk_total';
    public const FIELD_CPU_USER_USAGE = 'cpu_user_usage';
    public const FIELD_CPU_SYSTEM_USAGE = 'cpu_system_usage';
    public const FIELD_CPU_IDLE = 'cpu_idle';

    public $timestamps = false;

    protected $fillable = [
        self::FIELD_DISK_NAME,
        self::FIELD_DISK_AVAILABLE,
        self::FIELD_DISK_USED,
        self::FIELD_DISK_TOTAL,
        self::FIELD_CPU_USER_USAGE,
        self::FIELD_CPU_SYSTEM_USAGE,
        self::FIELD_CPU_IDLE,
        self::CREATED_AT,
    ];

    protected $dates = [
        self::CREATED_AT,
    ];
}
