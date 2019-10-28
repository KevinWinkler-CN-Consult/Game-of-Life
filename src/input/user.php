<?php

namespace GOL\Input;

use GOL\Boards\Board;
use Ulrichsg\Getopt;

/**
 * User input
 * Allows user to set cells alive manually by using the x- and y-coords of the cells.
 * Use prepareBoard() to prepare a Board and register() to register optional arguments.
 */
class User extends Input
{
    /**
     * Prepares a Board for usage.
     * @param Board $_board Board to prepare.
     * @param Getopt $_getopt Option manager to check for optional arguments.
     */
    public function prepareBoard(Board &$_board, Getopt $_getopt): void
    {
        echo "Enter the x-coordinates, the y-coordinates and the state of your cell to 0(dead) or, by default, to 1(alive), seperated by a comma.\n" .
            "Example: \"25,10,1\" will set the cell at x:25 and y:10 to the state \"alive\".\n\n" .
            "(Enter \"finish\" to continue.)\n";

        while (true)
        {
            $_board->printBoard();
            $readline = readline("Cell >> ");
            if ($readline == "finish")
                break;
            $coordinates = explode(",", $readline);

            if (count($coordinates) == 3)
            {
                $_board->setCell($coordinates[0], $coordinates[1], $coordinates[2]);
            }

            if (count($coordinates) == 2)
            {
                $_board->setCell($coordinates[0], $coordinates[1], 1);
            }
        }

    }

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
        return "Allows to set the state of specific cells.";
    }
}