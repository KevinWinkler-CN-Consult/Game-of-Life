<?php

namespace GOL\Input;

use GOL\Boards\Board;
use Ulrichsg\Getopt;

/**
 * Interface for pluggable inputs.
 *
 * Use prepareBoard() to prepare a Board and register()
 * to register optional arguments.
 */
abstract class Input
{
    /**
     * Prepares a Board for usage.
     * @param Board $_board Board to prepare.
     * @param Getopt $_getopt Option manager to check for optional arguments.
     */
    abstract public function prepareBoard(Board &$_board, Getopt $_getopt): void;

    /**
     * Register all optional parameters of an Input, if any.
     * @param Getopt $_getopt Option manager to add the options
     */
    public function register(Getopt $_getopt): void
    {
    }

    /**
     * Returns the description of the Input.
     * @return string description.
     */
    public function description(): string
    {
        return "";
    }
}