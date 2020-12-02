<?php

namespace App\Bundles\Landing\Models;

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
    protected $table = 'landing_feed_backs';
}
