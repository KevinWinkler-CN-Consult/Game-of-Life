<?php

namespace GOL;

use GOL\Boards\Board;
use GOL\Boards\History;
use GOL\Rules\Rule;

/**
 * Controls the game logic of the game.
 * Use nextGeneration() to calculate the next generation.
 */
class GameLogic
{
    private $rule;
    private $history;
    private $isLooping;
    private $historyLength;

    /**
     * @param Board $_board Initial board to save to the history.
     * @param Rule $_rule Rule to calculate the next generation.
     */
    public function __construct(Board $_board, Rule $_rule)
    {
        $this->historyLength = 2;
        $this->history = new History($_board);
        $this->isLooping = false;
        $this->rule = $_rule;
    }

    /**
     * Calculates the next generation of a board.
     * @param Board $_board board to use.
     */
    public function nextGeneration(Board $_board)
    {
        $buffer = $_board->getGrid();

        for ($y = 0; $y < $_board->height(); $y++)
        {
            for ($x = 0; $x < $_board->width(); $x++)
            {
                $cell = $_board->getCell($x, $y);
                $nextState = $this->rule->apply($cell);
                $buffer[$x][$y] = $nextState;
            }
        }

        for ($y = 0; $y < $_board->height(); $y++)
        {
            for ($x = 0; $x < $_board->width(); $x++)
            {
                $_board->setCell($x, $y, $buffer[$x][$y]);
            }
        }

        if ($this->history->stackSize() > $this->historyLength)
            $this->history->removeOldestBoard();

        if ($this->history->compare($_board))
            $this->isLooping = true;

        $this->history->push($_board);
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
     * @param int $_historyLength Length of the history.
     */
    public function setHistoryLength(int $_historyLength): void
    {
        $this->historyLength = $_historyLength;
    }
}