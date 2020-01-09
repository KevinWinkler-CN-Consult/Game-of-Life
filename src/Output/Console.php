<?php

namespace GOL\Output;

use GOL\Boards\Board;
use GOL\Helper\Clock;

/**
 * Prints the board to the console.
 *
 * Use write() to write the Board data to the buffer.
 * and flush() to print the buffer.
 */
class Console extends Output
{
    /**
     * Writes the current board to the Output.
     *
     * @param Board $_board Board to output.
     */
    public function write(Board $_board): void
    {
        $board = $_board->getGrid();
        $width = count($board);
        $height = count($board[0]);

        for ($y = 0; $y < $height; $y++)
        {
            for ($x = 0; $x < $width; $x++)
            {
                echo $board[$x][$y] ? "O" : "-";
            }
            echo "\n";
        }
        echo "\n";
    }

    /**
     * Returns the description of the Output.
     * @return string description.
     */
    public function description(): string
    {
        return "Outputs the Board to the console.";
    }
}