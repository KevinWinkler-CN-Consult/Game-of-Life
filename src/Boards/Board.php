<?php

namespace GOL\Boards;

/**
 * Represents a Game of Life world.
 *
 * Use print() to print the board and nextGeneration() to calculate the next generation.
 */
class Board
{
    protected $grid;
    protected $width;
    protected $height;

    /**
     * @param int $_width Width of the Board.
     * @param int $_height Height af the Board.
     */
    public function __construct($_width, $_height)
    {
        $this->width = $_width;
        $this->height = $_height;

        // initialize the board
        for ($y = 0; $y < $_height + 2; $y++)
        {
            for ($x = 0; $x < $_width + 2; $x++)
            {
                $this->grid[$x][$y] = 0;
            }
        }
    }

    /**
     * Runs the Game of Life algorithm.
     */
    public function nextGeneration()
    {
        $buffer = $this->grid;

        for ($y = 1; $y < $this->height + 1; $y++)
        {
            for ($x = 1; $x < $this->width + 1; $x++)
            {
                $buffer[$x][$y] = $this->applyRule($this->countLivingNeighbours($x, $y), $this->grid[$x][$y]);
            }
        }

        $this->grid = $buffer;
    }

    /**
     * @param int $_numNeighbours Number of living cells in the neighbourhood.
     * @param bool $_isAlive State of the current cell.
     * @return int State of the cell in the next generation.
     */
    private function applyRule($_numNeighbours, $_isAlive)
    {
        $survival = [2, 3];
        $birth = [3];

        if ($_isAlive)
        {
            foreach ($survival as $s)
            {
                if ($_numNeighbours == $s)
                    return 1;
            }
        }
        else
        {
            foreach ($birth as $b)
            {
                if ($_numNeighbours == $b)
                    return 1;
            }
        }

        return 0;
    }

    /**
     * Returns the amount of living cells in the neighbourhood of a specific cell.
     *
     * No out of bound check due to the margin.
     *
     * @param int $_x y coordinate of the specific cell.
     * @param int $_y y coordinate of the specific cell.
     * @return int amount of living cells and -1 if given cell is out of bounds.
     */
    private function countLivingNeighbours($_x, $_y)
    {
        // out of bounds and margin check
        if ($_x < 1 || $_y < 1 || $_x > $this->width || $_y > $this->height)
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

    /**
     * Compares the current board with the history.
     *
     * @param Board $_board board to check.
     * @return bool true if one of the previous boards is equal to to current board, false otherwise.
     */
    public function compare(Board $_board)
    {
        $equal = true;

        for ($y = 1; $y < $_board->height() + 1; $y++)
        {
            for ($x = 1; $x < $_board->width() + 1; $x++)
            {
                if ($this->grid[$x][$y] != $_board->grid[$x][$y])
                    $equal = false;
            }
        }

        return $equal;
    }

    /**
     * Changes the value of a cell.
     * @param int $_x X position of the cell.
     * @param int $_y Y position of the cell.
     * @param int $_value new value of the cell.
     */
    public function setCell($_x, $_y, $_value)
    {
        if ($_x < 0 || $_y < 0 || $_x >= $this->width || $_y >= $this->height)
            return;

        $this->grid[$_x + 1][$_y + 1] = $_value;
    }

    /**
     * Returns a copy of the grid data
     * @return array Grid of the Board.
     */
    public function getGrid(): array
    {
        $result = array();

        for ($y = 1; $y < $this->height + 1; $y++)
        {
            for ($x = 1; $x < $this->width + 1; $x++)
            {
                $result[$x - 1][$y - 1] = $this->grid[$x][$y];
            }
        }

        return $result;
    }

    /**
     * Returns the width of the board.
     * @return int Width of the board.
     */
    public function width()
    {
        return $this->width;
    }

    /**
     * Returns the height of the board.
     * @return int height of the board.
     */
    public function height()
    {
        return $this->height;
    }
}