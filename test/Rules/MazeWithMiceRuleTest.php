<?php

namespace Rules;

use GOL\Boards\Board;
use GOL\Rules\MazeWithMiceRule;
use PHPUnit\Framework\TestCase;

class MazeWithMiceRuleTest extends TestCase
{
    /**
     * @test
     */
    public function noLivingNeighboursYieldDeadCell()
    {
        $board = new Board(4, 4);
        $rule = new MazeWithMiceRule();

        $newValue = $rule->apply($board->getCell(1, 1));
        $this->assertFalse($newValue);
    }

    /**
     * @test
     */
    public function noLivingNeighboursYieldDeadCell2()
    {
        $board = new Board(4, 4);
        $rule = new MazeWithMiceRule();

        $board->setCell(1, 1, true);

        $newValue = $rule->apply($board->getCell(1, 1));
        $this->assertFalse($newValue);
    }

    /**
     * @test
     */
    public function surviveOn1Neighbour()
    {
        $board = new Board(4, 4);
        $rule = new MazeWithMiceRule();

        $board->setCell(1, 1, true);

        $board->setCell(0, 0, true);

        $newValue = $rule->apply($board->getCell(1, 1));
        $this->assertTrue($newValue);
    }

    /**
     * @test
     */
    public function surviveOn2Neighbours()
    {
        $board = new Board(4, 4);
        $rule = new MazeWithMiceRule();

        $board->setCell(1, 1, true);

        $board->setCell(0, 0, true);
        $board->setCell(0, 1, true);

        $newValue = $rule->apply($board->getCell(1, 1));
        $this->assertTrue($newValue);
    }

    /**
     * @test
     */
    public function surviveOn3Neighbours()
    {
        $board = new Board(4, 4);
        $rule = new MazeWithMiceRule();

        $board->setCell(1, 1, true);

        $board->setCell(0, 0, true);
        $board->setCell(0, 1, true);
        $board->setCell(1, 0, true);

        $newValue = $rule->apply($board->getCell(1, 1));
        $this->assertTrue($newValue);
    }

    /**
     * @test
     */
    public function surviveOn4Neighbours()
    {
        $board = new Board(4, 4);
        $rule = new MazeWithMiceRule();

        $board->setCell(1, 1, true);

        $board->setCell(0, 0, true);
        $board->setCell(0, 1, true);
        $board->setCell(1, 0, true);
        $board->setCell(2, 0, true);

        $newValue = $rule->apply($board->getCell(1, 1));
        $this->assertTrue($newValue);
    }

    /**
     * @test
     */
    public function surviveOn5Neighbours()
    {
        $board = new Board(4, 4);
        $rule = new MazeWithMiceRule();

        $board->setCell(1, 1, true);

        $board->setCell(0, 0, true);
        $board->setCell(0, 1, true);
        $board->setCell(1, 0, true);
        $board->setCell(2, 0, true);
        $board->setCell(0, 2, true);

        $newValue = $rule->apply($board->getCell(1, 1));
        $this->assertTrue($newValue);
    }

    /**
     * @test
     */
    public function birthOn3Neighbours()
    {
        $board = new Board(4, 4);
        $rule = new MazeWithMiceRule();

        $board->setCell(0, 0, true);
        $board->setCell(0, 1, true);
        $board->setCell(1, 0, true);

        $newValue = $rule->apply($board->getCell(1, 1));
        $this->assertTrue($newValue);
    }

    /**
     * @test
     */
    public function birthOn7Neighbours()
    {
        $board = new Board(4, 4);
        $rule = new MazeWithMiceRule();

        $board->setCell(0, 0, true);
        $board->setCell(0, 1, true);
        $board->setCell(1, 0, true);
        $board->setCell(2, 0, true);
        $board->setCell(0, 2, true);
        $board->setCell(2, 1, true);
        $board->setCell(1, 2, true);

        $newValue = $rule->apply($board->getCell(1, 1));
        $this->assertTrue($newValue);
    }
}