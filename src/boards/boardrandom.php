<?php

namespace GOL\Boards;

/**
 * Represents a Game of Life world filled randomly with values of 1 or 0.
 *
 * Use print() to print the board and nextGeneration() to calculate the next generation.
 */
class BoardRandom extends Board
{
    /**
     * @param int $_width Width of the Board with margin.
     * @param int $_height Height af the Board with margin.
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