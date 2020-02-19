<?php

namespace Rules;

use GOL\Boards\Board;
use GOL\Rules\MazeRule;
use PHPUnit\Framework\TestCase;

class MazeRuleTest extends TestCase
{
    /**
     * @test
     */
    public function noLivingNeighboursYieldDeadCell()
    {
        $board = new Board(4, 4);
        $rule = new MazeRule();

        $newValue = $rule->apply($board->field(1, 1));
        $this->assertFalse($newValue);
    }

    /**
     * @test
     */
    public function noLivingNeighboursYieldDeadCell2()
    {
        $board = new Board(4, 4);
        $rule = new MazeRule();

        $board->setFieldValue(1, 1, true);

        $newValue = $rule->apply($board->field(1, 1));
        $this->assertFalse($newValue);
    }

    /**
     * @test
     */
    public function surviveOn1Neighbour()
    {
        $board = new Board(4, 4);
        $rule = new MazeRule();

        $board->setFieldValue(1, 1, true);

        $board->setFieldValue(0, 0, true);

        $newValue = $rule->apply($board->field(1, 1));
        $this->assertTrue($newValue);
    }

    /**
     * @test
     */
    public function surviveOn2Neighbours()
    {
        $board = new Board(4, 4);
        $rule = new MazeRule();

        $board->setFieldValue(1, 1, true);

        $board->setFieldValue(0, 0, true);
        $board->setFieldValue(0, 1, true);

        $newValue = $rule->apply($board->field(1, 1));
        $this->assertTrue($newValue);
    }

    /**
     * @test
     */
    public function surviveOn3Neighbours()
    {
        $board = new Board(4, 4);
        $rule = new MazeRule();

        $board->setFieldValue(1, 1, true);

        $board->setFieldValue(0, 0, true);
        $board->setFieldValue(0, 1, true);
        $board->setFieldValue(1, 0, true);

        $newValue = $rule->apply($board->field(1, 1));
        $this->assertTrue($newValue);
    }

    /**
     * @test
     */
    public function surviveOn4Neighbours()
    {
        $board = new Board(4, 4);
        $rule = new MazeRule();

        $board->setFieldValue(1, 1, true);

        $board->setFieldValue(0, 0, true);
        $board->setFieldValue(0, 1, true);
        $board->setFieldValue(1, 0, true);
        $board->setFieldValue(2, 0, true);

        $newValue = $rule->apply($board->field(1, 1));
        $this->assertTrue($newValue);
    }

    /**
     * @test
     */
    public function surviveOn5Neighbours()
    {
        $board = new Board(4, 4);
        $rule = new MazeRule();

        $board->setFieldValue(1, 1, true);

        $board->setFieldValue(0, 0, true);
        $board->setFieldValue(0, 1, true);
        $board->setFieldValue(1, 0, true);
        $board->setFieldValue(2, 0, true);
        $board->setFieldValue(0, 2, true);

        $newValue = $rule->apply($board->field(1, 1));
        $this->assertTrue($newValue);
    }

    /**
     * @test
     */
    public function birthOn3Neighbours()
    {
        $board = new Board(4, 4);
        $rule = new MazeRule();

        $board->setFieldValue(0, 0, true);
        $board->setFieldValue(0, 1, true);
        $board->setFieldValue(1, 0, true);

        $newValue = $rule->apply($board->field(1, 1));
        $this->assertTrue($newValue);
    }
}
