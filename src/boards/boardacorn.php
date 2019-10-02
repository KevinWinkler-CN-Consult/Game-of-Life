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
     * @param int $_width Width of the Board.
     * @param int $_height Height af the Board.
     */
    function __construct($_width, $_height)
    {
        parent::__construct($_width, $_height);

        // fill the board with a acorn in the center if the board is big enough
        if ($_width >= 7 && $_height >= 3)
        {
            $offsetX = floor($_width / 2 - 7 / 2);
            $offsetY = floor($_height / 2 - 3 / 2);

            $this->setCell(0 + $offsetX, 0 + $offsetY, 1);
            $this->setCell(1 + $offsetX, 0 + $offsetY, 1);

            $this->setCell(4 + $offsetX, 0 + $offsetY, 1);
            $this->setCell(5 + $offsetX, 0 + $offsetY, 1);
            $this->setCell(6 + $offsetX, 0 + $offsetY, 1);

            $this->setCell(3 + $offsetX, 1 + $offsetY, 1);

            $this->setCell(1 + $offsetX, 2 + $offsetY, 1);
        }
    }
}