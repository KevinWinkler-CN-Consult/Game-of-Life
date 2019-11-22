<?php

namespace GOL\Boards;

/**
 * Tracks previous version of a board.
 *
 * Use compare() to compare the current board with the previous versions.
 * Use push() to add the current board to the history and pop() to remove the oldest board.
 */
class History
{
    protected $previousBoards = [];

    /**
     * @param Board $board First generation of the board.
     */
    public function __construct(Board $board)
    {
        $this->push($board);
    }

    /**
     * Compares the current board with the history.
     *
     * @param Board $_board board to check.
     * @return bool true if one of the previous boards is equal to to current board, false otherwise.
     */
    public function compare(Board $_board)
    {
        foreach ($this->previousBoards as $previousBoard)
        {
            if ($_board->compare($previousBoard))
                return true;
        }
        return false;
    }

    /**
     * Adds the board to the history.
     * @param Board $board board to add.
     */
    public function push(Board $board)
    {
        $temp = clone $board;
        array_unshift($this->previousBoards, $temp);
    }

    /**
     * Removes the oldest board from the history.
     */
    public function pop()
    {
        array_pop($this->previousBoards);
    }

    /**
     * Returns the number of boards in the history.
     * @return int number of boards.
     */
    public function stackSize()
    {
        return count($this->previousBoards);
    }
}