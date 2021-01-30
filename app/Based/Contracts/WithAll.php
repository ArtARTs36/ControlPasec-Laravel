<?php

namespace App\Based\Contracts;

interface WithAll
{
    /**
     * @param  array|mixed  $columns
     * @return \Illuminate\Database\Eloquent\Collection<static>
     */
    public static function all($columns = ['*']);
}
