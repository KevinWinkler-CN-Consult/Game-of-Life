<?php


namespace GOL\Helper;

/**
 * A simple read line wrapper to allow tests.
 * @codeCoverageIgnore
 */
class Readline
{
    /** Reads a line
     * @link https://php.net/manual/en/function.readline.php
     * @param string $prompt [optional] <p>
     * You may specify a string with which to prompt the user.
     * </p>
     * @return string a single string from the user. The line returned has the ending
     * newline removed.
     */
    public function readline($prompt = null)
    {
        return readline($prompt);
    }
}