<?php

namespace GOL\Output;

use GOL\Boards\Board;
use Ulrichsg\Getopt;

/**
 * Base class for pluggable outputs.
 *
 * Implement write() to write the Board data to the output and
 * implement flush() to output the data.
 */
abstract class Output
{
    /**
     * Writes the current board to the Output.
     *
     * @param Board $_board Board to output.
     */
    abstract public function write(Board $_board): void;

    /**
     * Outputs the data.
     */
    public function flush(): void
    {
    }

    /**
     * Checks for optional parameters.
     * @param Getopt $_getopt Option manager to check for optional parameters.
     */
    public function checkParamerters(Getopt $_getopt): void
    {
    }

    /**
     * Register all optional parameters of an Output, if any.
     * @param Getopt $_getopt Option manager to add the options
     */
    public function register(Getopt $_getopt): void
    {
    }

    /**
     * Returns the description of the Output.
     * @return string description.
     */
    public function description(): string
    {
        return "";
    }
}