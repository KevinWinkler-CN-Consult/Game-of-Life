<?php

namespace GOL\Boards;

/**
 * Represents a Game of Life world.
 *
 * Use grid() to retrieve the current grid and setGrid() to apply all changes.
 *
 * The size of the actual working area is the size -2 due to a margin to remove
 * out of bounds check in getNeighbours() if the given cell would be on the border.
 */
class Board
{
    protected $grid;
    protected $width;
    protected $height;

    /**
     * @param $_width int Width of the Board with margin.
     * @param $_height int Height af the Board with margin.
     */
    public function __construct($_width, $_height)
    {
        $this->width = $_width;
        $this->height = $_height;

        // initialize the board
        for ($y = 0; $y < $_height; $y++)
        {
            for ($x = 0; $x < $_width; $x++)
            {
                $this->grid[$x][$y] = 0;
            }
        }
    }

    /**
     * Prints the board to the console.
     */
    public function printBoard()
    {
        for ($y = 0; $y < $this->height; $y++)
        {
            for ($x = 0; $x < $this->width; $x++)
                echo $this->grid[$x][$y] ? "O" : "-";
            echo "\n";
        }
    }

    /**
     * Returns the board.
     * @return array 2d array with width and height of the board.
     */
    public function grid()
    {
        return $this->grid;
    }

    /**
     * Returns the width of the board including the margin.
     * @return int Width of the board.
     */
    public function width()
    {
        return $this->width;
    }

    /**
     * Returns the size of the board.
     * @return int Size of the board.
     */
    public function height()
    {
        return $this->height;
    }

    /**
     * Overrides the current grid.
     * @param array $_grid Source data.
     */
    public function setGrid(array $_grid)
    {
        //TODO:prevent out of bounds or implement in board buffer
        for ($x = 0; $x < $this->height; $x++)
            for ($y = 0; $y < $this->width; $y++)
                $this->grid[$x][$y] = $_grid[$x][$y];
    }

    /**
     * Returns the amount of living cells in the neighbourhood of a specific cell.
     *
     * No out of bound check due to the margin.
     *
     * @param $_x int y coordinate of the specific cell
     * @param $_y int y coordinate of the specific cell
     * @return int amount of living cells and -1 if given cell is out of bounds or on the margin.
     */
    public function countLivingNeighbours($_x, $_y)
    {
        // out of bounds and margin check
        if ($_x < 1 || $_y < 1 || $_x > $this->width - 1 || $_y > $this->height - 1)
            return -1;

        $relativeNeighbourIndices = [[-1, -1], [0, -1], [1, -1], [-1, 0], [1, 0], [-1, 1], [0, 1], [1, 1]];
        $livingNeighbourCount = 0;

        foreach ($relativeNeighbourIndices as $relativeNeighbour)
        {
            if ($this->grid[$_x + $relativeNeighbour[0]][$_y + $relativeNeighbour[1]] == 1)
                $livingNeighbourCount++;
        }

        return $livingNeighbourCount;
    }
}