<?php

namespace GOL\Output;

use GetOpt\Getopt;
use GOL\Boards\Board;
use GOL\Helper\Clock;

/**
 * Base class for pluggable outputs.
 *
 * Implement write() to write the Board data to the output and
 * implement flush() to output the data.
 * @codeCoverageIgnore
 */
abstract class Output
{
    protected $clock = null;

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
    public function checkParameters(Getopt $_getopt): void
    {
    }

    /**
     * Register all optional parameters of an Input, if any.
     * @return array Array of options.
     */
    public function register(): array
    {
        return [];
    }

    /**
     * Returns the description of the Output.
     * This is used to list all outputs if the argument outputList is set.
     * @return string description.
     */
    public function description(): string
    {
        return "";
    }

    public function setClock(Clock $clock)
    {
        $this->clock = $clock;
    }
}