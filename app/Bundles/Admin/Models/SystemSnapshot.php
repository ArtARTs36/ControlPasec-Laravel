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

    public const STATE_CPU_GOOD = 1;
    public const STATE_CPU_NORMAL = 2;
    public const STATE_CPU_BAD = 3;
    public const STATE_CPU_CRITICAL = 4;
    public const STATE_CPU_TEXTS = [
        self::STATE_CPU_GOOD => 'Хорошо',
        self::STATE_CPU_NORMAL => 'Нормально',
        self::STATE_CPU_BAD => 'Плохо',
        self::STATE_CPU_CRITICAL => 'Критично',
    ];

    public const STATE_DISK_GOOD = 1;
    public const STATE_DISK_NORMAL = 2;
    public const STATE_DISK_BAD = 3;
    public const STATE_DISK_CRITICAL = 4;
    public const STATE_DISK_TEXTS = [
        self::STATE_DISK_GOOD => 'Хорошо',
        self::STATE_DISK_NORMAL => 'Нормально',
        self::STATE_DISK_BAD => 'Плохо',
        self::STATE_DISK_CRITICAL => 'Критично',
    ];

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

    public function getTotalCpu(): float
    {
        return $this->cpu_system_usage + $this->cpu_user_usage;
    }

    public function getCpuState(): int
    {
        if ($this->cpu_idle > 55) {
            return static::STATE_CPU_GOOD;
        } elseif ($this->cpu_idle > 35) {
            return static::STATE_CPU_NORMAL;
        } elseif ($this->cpu_idle > 15) {
            return static::STATE_CPU_BAD;
        }

        return static::STATE_CPU_CRITICAL;
    }

    public function getCpuStateText(): string
    {
        return static::STATE_CPU_TEXTS[$this->getCpuState()] ?? static::STATE_CPU_TEXTS[static::STATE_CPU_BAD];
    }

    public function getDiskState(): int
    {
        $percent = $this->getDiskAvailablePercent();

        if ($percent > 65) {
            return static::STATE_DISK_GOOD;
        } elseif ($percent > 40) {
            return static::STATE_DISK_NORMAL;
        } elseif ($percent > 20) {
            return static::STATE_DISK_BAD;
        }

        return static::STATE_DISK_CRITICAL;
    }

    public function getDiskStateText(): string
    {
        return static::STATE_DISK_TEXTS[$this->getCpuState()] ?? static::STATE_DISK_TEXTS[static::STATE_DISK_BAD];
    }

    public function getDiskAvailablePercent(): float
    {
        return ($this->disk_available / $this->disk_total) * 100;
    }
}
