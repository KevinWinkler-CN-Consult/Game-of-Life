<?php

namespace GOL\Boards;

/**
 * Represents a Game of Life world filled randomly with values of 1 or 0.
 *
 * Use grid() to retrieve the current grid and setGrid() to apply all changes.
 *
 * The size of the actual working area is the size -2 due to a margin to remove
 * out of bounds check in getNeighbours() if the given cell would be on the border.
 */
class BoardRandom extends Board
{
    /**
     * @param $_width int Width of the Board.
     * @param $_height int Height af the Board.
     */
    function __construct($_width, $_height)
    {
        parent::__construct($_width, $_height);

        // fill the board with random zeros or ones
        for ($y = 1; $y < $_height - 1; $y++)
        {
            for ($x = 1; $x < $_width - 1; $x++)
            {
                $this->grid[$x][$y] = rand(0, 1);
            }
        }
    }
}