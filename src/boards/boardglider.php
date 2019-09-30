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
     * @param int $_width Width of the Board with margin.
     * @param int $_height Height af the Board with margin.
     */
    function __construct($_width, $_height)
    {
        parent::__construct($_width, $_height);

        // fill the board with a glider if the board is big enough
        if ($_width >= 5 && $_height >= 5)
        {
            $this->grid[1][1] = 0;
            $this->grid[2][1] = 1;
            $this->grid[3][1] = 0;

            $this->grid[1][2] = 0;
            $this->grid[2][2] = 0;
            $this->grid[3][2] = 1;

            $this->grid[1][3] = 1;
            $this->grid[2][3] = 1;
            $this->grid[3][3] = 1;
        }
    }
}