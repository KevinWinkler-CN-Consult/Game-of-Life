<?php

/**
 * Returns a holiday color. A background and a foreground color.
 * @return array of 6 integers 2x rgb if today is a holiday , otherwise an empty array.
 */
function getHolidayColor(): array
{

    if (date("m-d") == "10-31")
    { // halloween
        return [0, 0, 0, 255, 153, 0];
    }

    return [];
}