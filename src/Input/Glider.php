<?php

namespace GOL\Input;

use GetOpt\Getopt;
use GetOpt\Option;
use GOL\Boards\Board;

/**
 * Fills the board with a glider.
 *
 * Use prepareBoard() to prepare a Board and register()
 * to register optional arguments.
 */
class Glider extends Input
{
    /**
     * Prepares a Board for usage.
     * @param Board $_board Board to prepare.
     * @param Getopt $_getopt Option manager to check for optional arguments.
     */
    public function prepareBoard(Board &$_board, Getopt $_getopt): void
    {
        $positionX = floor($_board->width() / 2 - 1.5);
        $positionY = floor($_board->height() / 2 - 1.5);

        if ($_getopt->getOption("gliderPosition"))
        {
            $arg = explode(',', $_getopt->getOption("gliderPosition"));
            $positionX = intval($arg[0]);
            $positionY = intval($arg[1]);
        }

        $_board->setCell($positionX + 1, $positionY + 0, 1);

        $_board->setCell($positionX + 2, $positionY + 1, 1);

        $_board->setCell($positionX + 0, $positionY + 2, 1);
        $_board->setCell($positionX + 1, $positionY + 2, 1);
        $_board->setCell($positionX + 2, $positionY + 2, 1);
    }

    /**
     * Register all optional parameters of an Input, if any.
     * @return array Array of options.
     */
    public function register(): array
    {
        $result = [];

        $result[] = new Option(null, "gliderPosition", Getopt::REQUIRED_ARGUMENT);
        end($result)->setDescription("Sets the position of the glider \"x,y\"");

        return $result;
    }

    /**
     * Returns the description of the Input.
     * @return string description.
     */
    public function description(): string
    {
        return "creates a board with a glider";
    }
}