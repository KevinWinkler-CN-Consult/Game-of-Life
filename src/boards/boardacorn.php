<?php

namespace GOL\Boards;

/**
 * Represents a Game of Life world with the acorn pattern in the centre.
 *
 * Use print() to print the board and nextGeneration() to calculate the next generation.
 */
class BoardAcorn extends Board
{
    /**
     * @param int $_width Width of the Board with margin.
     * @param int $_height Height af the Board with margin.
     */
    function __construct($_width, $_height)
    {
        parent::__construct($_width, $_height);

        // fill the board with a acorn in the center if the board is big enough
        if ($_width > 9 && $_height > 5)
        {
            $offsetX = floor($_width / 2 - 7 / 2);
            $offsetY = floor($_height / 2 - 3 / 2);

            $this->grid[1 + $offsetX][0 + $offsetY] = 1;

            $this->grid[3 + $offsetX][1 + $offsetY] = 1;

            $this->grid[0 + $offsetX][2 + $offsetY] = 1;
            $this->grid[1 + $offsetX][2 + $offsetY] = 1;
            $this->grid[4 + $offsetX][2 + $offsetY] = 1;
            $this->grid[5 + $offsetX][2 + $offsetY] = 1;
            $this->grid[6 + $offsetX][2 + $offsetY] = 1;
        }
    }
}