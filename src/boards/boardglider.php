<?php

namespace GOL\Boards;

/**
 * Represents a Game of Life world with a glider in the top left corner.
 *
 * Use print() to print the board and nextGeneration() to calculate the next generation.
 */
class BoardGlider extends Board
{
    /**
     * @param int $_width Width of the Board.
     * @param int $_height Height af the Board.
     */
    function __construct($_width, $_height)
    {
        parent::__construct($_width, $_height);

        // fill the board with a glider if the board is big enough
        if ($_width >= 3 && $_height >= 3)
        {
            $this->setCell(1, 0, 1);

            $this->setCell(2, 1, 1);

            $this->setCell(0, 2, 1);
            $this->setCell(1, 2, 1);
            $this->setCell(2, 2, 1);
        }
    }
}