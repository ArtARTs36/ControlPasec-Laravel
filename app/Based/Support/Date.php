<?php

namespace App\Based\Support;

class Date
{
    public static function getCountFromPeriod(\DatePeriod $period): int
    {
        $count = 0;

        foreach ($period as $date) {
            $count++;
        }

        return $count;
    }
}
