<?php


namespace GOL\Helper;

/**
 * A simple date wrapper to allow tests.
 * @codeCoverageIgnore
 */
class Clock
{
    /**
     * Format a local time/date
     * @link https://php.net/manual/en/function.date.php
     * @param string $format
     * @param int $timestamp [optional] The optional timestamp parameter is an integer Unix timestamp
     * that defaults to the current local time if a timestamp is not given.
     * In other words, it defaults to the value of time().
     * @return string|false a formatted date string. If a non-numeric value is used for
     * timestamp, false is returned and an
     * E_WARNING level error is emitted.
     * @since 4.0
     * @since 5.0
     */
    public function date($format, $timestamp = 0)
    {
        $time = $timestamp ?? time();
        date($format,$time);
    }
}