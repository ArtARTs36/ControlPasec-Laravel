<?php

namespace App\Bundles\Admin\Entities;

use ArtARTs36\GitHandler\Support\ToArray;
use Illuminate\Contracts\Support\Arrayable;

class AppChange implements Arrayable
{
    use ToArray;

    public $title;

    public $author;

    public $date;

    public $subject;

    public function __construct(string $title, string $author, \DateTimeInterface $date, string $subject)
    {
        $this->title = $title;
        $this->author = $author;
        $this->date = $date->format('Y-m-d H:i:s');
        $this->subject = $subject;
    }
}

