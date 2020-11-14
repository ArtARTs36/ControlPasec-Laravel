<?php

namespace App\Models\Landing;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * Class LandingFeedBack
 * @property int $id
 * @property string $people_title
 * @property string $people_email
 * @property string $people_phone
 * @property string $message
 * @property string $ip
 * @mixin Builder
 */
final class LandingFeedBack extends Model
{
    public const FIELD_MESSAGE = 'message';

    protected $table = 'landing_feed_backs';
}
