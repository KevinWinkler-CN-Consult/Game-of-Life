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
     * @param int $_width Width of the Board.
     * @param int $_height Height af the Board.
     */
    function __construct($_width, $_height)
    {
        parent::__construct($_width, $_height);

        // fill the board with random zeros or ones
        for ($y = 0; $y < $_height; $y++)
        {
            for ($x = 0; $x < $_width; $x++)
            {
                $this->setCell($x, $y, rand(0, 1));
            }
        }
    }
}