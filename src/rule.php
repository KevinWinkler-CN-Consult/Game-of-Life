<?php

namespace GOL;

/**
 * Represents the rule of the Game of Life.
 *
 * Use applyRule() to check if a cell lives or dies in the next generation.
 */
class Rule
{
    private $birth;
    private $survival;

    /**
     * @param array $_birth List of neighbour counts on witch a cell is born in the next generation.
     * @param array $_survival List of neighbour counts on witch a cell survives to the next generation.
     */
    public function __construct(array $_birth, array $_survival)
    {
        $this->birth = $_birth;
        $this->survival = $_survival;
    }

    /**
     * @param int $_numNeighbours Number of living cells in the neighbourhood.
     * @param bool $_isAlive State of the current cell.
     * @return int State of the cell in the next generation.
     */
    public function applyRule($_numNeighbours, $_isAlive)
    {
        if ($_isAlive)
        {
            foreach ($this->survival as $s)
                if ($_numNeighbours == $s)
                    return 1;
        }
        else
        {
            foreach ($this->birth as $b)
                if ($_numNeighbours == $b)
                    return 1;
        }

        return 0;
    }
}