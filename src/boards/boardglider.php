<?php

namespace GOL\Boards;

/**
 * Represents a Game of Life world filled with a glider in the top left corner.
 *
 * Use grid() to retrieve the current grid and setGrid() to apply all changes.
 *
 * The size of the actual working area is the size -2 due to a margin to remove
 * out of bounds check in getNeighbours() if the given cell would be on the border.
 */
class BoardGlider extends Board
{
    /**
     * @param $_width int Width of the Board.
     * @param $_height int Height af the Board.
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