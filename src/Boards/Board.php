<?php

namespace GOL\Boards;

/**
 * Represents a Game of Life world.
 *
 * Use countLivingNeighbours() to calculate the number of living neighbours and compare() to compare two boards.
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

        // initialize the board with a one cell wide border
        // to prevent out of bounds check on every neighbour calculation
        for ($y = 0; $y < $_height + 2; $y++)
        {
            for ($x = 0; $x < $_width + 2; $x++)
            {
                $this->grid[$x][$y] = new Field($this, $x - 1, $y - 1);
            }
        }
    }

    /**
     * Returns the amount of living cells in the neighbourhood of a specific cell.
     *
     * @param Field $_field Field who's neighbours should be calculated.
     * @return int Amount of living cells and -1 if given cell is out of bounds.
     */
    public function countLivingNeighbours(Field $_field)
    {
        $livingNeighbourCount = -1;
        $x = $_field->x();
        $y = $_field->y();

        if (!$this->isOutOfBounds($x, $y))
        {
            $relativeNeighbourIndices = [[-1, -1], [0, -1], [1, -1], [-1, 0], [1, 0], [-1, 1], [0, 1], [1, 1]];
            $livingNeighbourCount++;

            foreach ($relativeNeighbourIndices as $relativeNeighbour)
            {
                if ($this->grid[$x + $relativeNeighbour[0] + 1][$y + $relativeNeighbour[1] + 1]->value() == 1)
                    $livingNeighbourCount++;
            }
        }
        return $livingNeighbourCount;
    }

    /**
     * Compares the board with another board.
     *
     * @param Board $_board board to check.
     * @return bool true if both boards are equal, false otherwise.
     */
    public function compare(Board $_board)
    {
        $equal = true;

        if ($_board->height() != $this->height() || $_board->width() != $this->width())
            return false;

        for ($y = 1; $y < $_board->height() + 1; $y++)
        {
            for ($x = 1; $x < $_board->width() + 1; $x++)
            {
                if ($this->grid[$x][$y]->value() != $_board->field($x - 1, $y - 1)->value())
                    $equal = false;
            }
        }

        return $equal;
    }

    /**
     * Changes the value of a field.
     * @param int $_x X position of the field.
     * @param int $_y Y position of the field.
     * @param int $_value new value of the field.
     */
    public function setFieldValue($_x, $_y, $_value)
    {
        if ($this->isOutOfBounds($_x, $_y))
            return;

        $this->grid[$_x + 1][$_y + 1]->setValue($_value);
    }

    /**
     * Returns a field at the given point.
     * @param int $_x X position of the field.
     * @param int $_y Y position of the field.
     * @return Field|null The field or null pointer on invalid coordinates.
     */
    public function field(int $_x, int $_y): ?Field
    {
        if ($this->isOutOfBounds($_x, $_y))
            return null;

        return $this->grid[$_x + 1][$_y + 1];
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
                $result[$x - 1][$y - 1] = $this->grid[$x][$y]->value();
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

    /**
     * Checks if a coordinate is out of bounds.
     * @param int $_x X position to check.
     * @param int $_y Y position to check.
     * @return bool True on out of bounds, otherwise false.
     */
    private function isOutOfBounds(int $_x, int $_y): bool
    {
        return $_x < 0 || $_y < 0 || $_x >= $this->width || $_y >= $this->height;
    }
}