<?php

namespace App\Bundles\Landing\Models;

use App\Based\ModelSupport\WithFillOfRequest;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $people_title
 * @property string $people_email
 * @property string $people_phone
 * @property string $message
 * @property string $ip
 */
final class FeedBack extends Model
{
    use WithFillOfRequest;

    public const FIELD_PEOPLE_TITLE = 'people_title';
    public const FIELD_PEOPLE_EMAIL = 'people_email';
    public const FIELD_PEOPLE_PHONE = 'people_phone';
    public const FIELD_MESSAGE = 'message';
    public const FIELD_IP = 'ip';

    protected $table = 'landing_feed_backs';

    protected $fillable = [
        self::FIELD_PEOPLE_TITLE,
        self::FIELD_PEOPLE_EMAIL,
        self::FIELD_PEOPLE_PHONE,
        self::FIELD_MESSAGE,
    ];
}
