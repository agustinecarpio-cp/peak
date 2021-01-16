<?php

namespace App\Helpers;

class TimeHelper
{
    public static function minuteToStringHoursMinute($minuteValue)
    {
        $hours = (int) ($minuteValue / 60);
        $hourString = $hours > 0 ? $hours . 'h ' : '';
        $minutes = $minuteValue % 60;
        $minuteString = $minutes . 'm';

        return $hourString . $minuteString;
    }
}
