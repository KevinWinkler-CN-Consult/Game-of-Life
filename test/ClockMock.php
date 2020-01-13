<?php


use GOL\Helper\Clock;

class ClockMock extends Clock
{
    private $date;

    public function __construct($_date)
    {
        $this->date = $_date;
    }

    public function date($format, $timestamp = 'time()')
    {
        return $this->date;
    }
}