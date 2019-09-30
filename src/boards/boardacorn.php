<?php

namespace GOL\Boards;

use GOL\Rule;

/**
 * Represents a Game of Life world filled with an acorn in the center.
 *
 * Use grid() to retrieve the current grid and setGrid() to apply all changes.
 *
 * The size of the actual working area is the size -2 due to a margin to remove
 * out of bounds check in getNeighbours() if the given cell would be on the border.
 */
class BoardAcorn extends Board
{
    /**
     * @param $_width int Width of the Board with margin.
     * @param $_height int Height af the Board with margin.
     * @param Rule $_rule rule used to generate the next generation.
     */
    function __construct($_width, $_height, Rule $_rule)
    {
        parent::__construct($_width, $_height, $_rule);

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