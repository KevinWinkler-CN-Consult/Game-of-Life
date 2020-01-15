<?php

namespace GOL;

use GOL\Boards\Board;
use GOL\Boards\History;

/**
 * Controls the game logic of the game.
 * Use nextGeneration to calculate the next generation.
 */
class GameLogic
{
    private $history;
    private $isLooping;
    private $historyLength;

    /**
     * @param Board $board Initial board to save to the history.
     */
    public function __construct(Board $board)
    {
        $this->historyLength = 2;
        $this->history = new History($board);
        $this->isLooping = false;
    }

    /**
     * Calculates the next generation of a board.
     * @param Board $board board to use.
     */
    public function nextGeneration(Board $board)
    {
        $board->nextGeneration();

        if ($this->history->stackSize() > $this->historyLength)
            $this->history->removeOldestBoard();

        if ($this->history->compare($board))
            $this->isLooping = true;

        $this->history->push($board);
    }

    /**
     * Checks if there is a loop.
     * @return bool True if a loop is detected, otherwise false.
     */
    public function isLooping()
    {
        return $this->isLooping;
    }

    /**
     * Changes how many steps are saved in the history.
     * @param int $historyLength Length of the history.
     */
    public function setHistoryLength(int $historyLength): void
    {
        $this->historyLength = $historyLength;
    }
}