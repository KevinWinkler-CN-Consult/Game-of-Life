<?php

namespace GOL\Input;

use GetOpt\Getopt;
use GetOpt\Option;
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
     * @return array Array of options.
     */
    public function register(): array
    {
        $result[] = new Option(null, "randomDensity", Getopt::REQUIRED_ARGUMENT);
        end($result)->setDescription("Density of the random distribution in 1-100%");

        return $result;
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