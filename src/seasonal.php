<?php

namespace GOL;

class Seasonal
{
    public static function getHolidayColor()
    {
        $date = date("d-m");

        if ($date == "31-10")
        { // halloween
            return [0, 0, 0, 255, 153, 0];
        }

        return [];
    }
}
