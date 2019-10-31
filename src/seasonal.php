<?php

/**
 * Returns a holiday color. A background and a foreground color.
 * @return array of 6 integers 2x rgb if today is a holiday , otherwise an empty array.
 */
function getHolidayColor(): array
{
    $dateToday = mktime(0,0,0,date("m"),date("d"));

    if( $dateToday - mktime(0,0,0,10,31) == 0 )// halloween
        return [0,0,0,255,153,0];

    return[];
}