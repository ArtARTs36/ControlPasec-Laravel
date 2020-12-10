<?php

namespace App\Based\Services\Calendar;

class Event
{
    protected $date;

    protected $title;

    protected $type;

    public function __construct(\DateTimeInterface $date, string $title, string $type)
    {
        $this->date = $date;
        $this->title = $title;
        $this->type = $type;
    }

    public function getYmdDate(): string
    {
        return $this->date->format('Y-m-d');
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getType(): string
    {
        return $this->type;
    }
}
