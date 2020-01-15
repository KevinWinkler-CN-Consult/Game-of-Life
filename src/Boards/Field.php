<?php

namespace GOL\Boards;

/**
 * Represents a single cell in Game of Life.
 *
 * Use numberOfLivingNeighbors() to get the number of living neighbours, value() to get the current state and
 * setValue() to change the state.
 */
class Field
{
    const maxNeighbours = 8;
    private $value;
    private $board;
    private $x;
    private $y;

    /**
     * @param Board $_board Parent board.
     * @param int $_x X position on the board.
     * @param int $_y Y position on the board.
     */
    public function __construct(Board $_board, $_x, $_y)
    {
        $this->x = $_x;
        $this->y = $_y;
        $this->board = $_board;

        $this->value = false;
    }

    /**
     * Sets the value of the cell.
     * @param bool $_value New cell value.
     */
    public function setValue($_value)
    {
        $this->value = $_value;
    }

    /**
     * Returns the value of the cell.
     * @return bool value of the cell.
     */
    public function value()
    {
        return $this->value;
    }

    /**
     * @return bool true if alive otherwise false.
     */
    public function isAlive()
    {
        return boolval($this->value);
    }

    /**
     * @return bool true if dead otherwise false.
     */
    public function isDead()
    {
        return !boolval($this->value);
    }

    /**
     * Returns the x position of the cell.
     * @return int X position of the cell.
     */
    public function x()
    {
        return $this->x;
    }

    /**
     * Returns the y position of the cell.
     * @return int y position of the cell.
     */
    public function y()
    {
        return $this->y;
    }

    /**
     * Returns the number of living neighbors.
     * @return int number of living neighbors.
     */
    public function numberOfLivingNeighbors()
    {
        return $this->board->countLivingNeighbours($this);
    }

    /**
     * Returns the number of dead neighbors.
     * @return int number of dead neighbors.
     */
    public function numberOfDeadNeighbors()
    {
        return self::maxNeighbours - $this->board->countLivingNeighbours($this);
    }
}