<?php

namespace GOL\Input;

use GetOpt\Getopt;
use GOL\Boards\Board;

/**
 * Fill the board with random values.
 *
 * Use prepareBoard() to prepare a Board and register()
 * to register optional arguments.
 */
class Random extends Input
{
    /**
     * Prepares a Board for usage.
     * @param Board $_board Board to prepare.
     * @param Getopt $_getopt Option manager to check for optional arguments.
     */
    public function prepareBoard(Board &$_board, Getopt $_getopt): void
    {
        $density = 50;
        if ($_getopt->getOption("randomDensity") != null)
            $density = intval($_getopt->getOption("randomDensity"));

        for ($y = 0; $y < $_board->height(); $y++)
        {
            for ($x = 0; $x < $_board->width(); $x++)
            {
                $_board->setCell($x, $y, (rand(0, 99) < $density ? 1 : 0));
            }
        }
    }

    /**
     * Register all optional parameters of an Input, if any.
     * @param Getopt $_getopt Option manager to add the options
     */
    public function register(Getopt $_getopt): void
    {
        $_getopt->addOptions(
            [
                [null, "randomDensity", Getopt::REQUIRED_ARGUMENT, "Density of the random distribution in 1-100%"]
            ]);
    }

    /**
     * Returns the description of the Input.
     * @return string description.
     */
    public function description(): string
    {
        return "creates a random board";
    }
}