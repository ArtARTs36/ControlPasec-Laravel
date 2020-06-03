<?php

namespace App\Senders\Push;

use App\User;

/**
 * Class Push
 * @package App\Senders
 */
class Push
{
    /** @var string|null  */
    public $title;

    /** @var string|null  */
    public $message;

    /** @var User|null  */
    public $user;

    /** @var string|null  */
    public $url;

    /**
     * Push constructor.
     * @param string|null $title
     * @param string|null $message
     * @param User|null $user
     * @param string|null $url
     */
    public function __construct(string $title = null, string $message = null, User $user = null, string $url = null)
    {
        $this->title = $title;
        $this->message = $message;
        $this->user = $user;
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function send()
    {
        return app(PusherInterface::class)->push($this);
    }

    /**
     * @return mixed
     */
    public function sendOrFail()
    {
        return app(PusherInterface::class)->pushOrFail($this);
    }
}
