<?php

namespace GOL\Input;

use GOL\Boards\Board;
use GetOpt\Getopt;

/**
 * Fills a board with the acorn pattern.
 *
 * Use prepareBoard() to prepare a Board and register()
 * to register optional arguments.
 */
class Acorn extends Input
{
    /**
     * Prepares a Board for usage.
     * @param Board $_board Board to prepare.
     * @param Getopt $_getopt Option manager to check for optional arguments.
     */
    public function prepareBoard(Board &$_board, Getopt $_getopt): void
    {
        $offsetX = floor($_board->width() / 2 - 7 / 2);
        $offsetY = floor($_board->height() / 2 - 3 / 2);

        $_board->setCell(0 + $offsetX, 0 + $offsetY, 1);
        $_board->setCell(1 + $offsetX, 0 + $offsetY, 1);

        $_board->setCell(4 + $offsetX, 0 + $offsetY, 1);
        $_board->setCell(5 + $offsetX, 0 + $offsetY, 1);
        $_board->setCell(6 + $offsetX, 0 + $offsetY, 1);

        $_board->setCell(3 + $offsetX, 1 + $offsetY, 1);

        $_board->setCell(1 + $offsetX, 2 + $offsetY, 1);
    }

    /**
     * Returns the description of the Input.
     * @return string description.
     */
    public function description(): string
    {
        return "creates a board with an acorn";
    }
}