<?php

use GOL\Helper\Clock;

/**
 * Returns a holiday color. A background and a foreground color.
 * @param Clock $_clock the clock device to use.
 * @return array of 6 integers 2x rgb if today is a holiday , otherwise an empty array.
 */
function getHolidayColor($_clock = null): array
{
    $clock = $_clock ?? new Clock();

    if ($clock->date("d-m") == "31-10")
    { // halloween
        return [0, 0, 0, 255, 153, 0];
    }

    return [];
}