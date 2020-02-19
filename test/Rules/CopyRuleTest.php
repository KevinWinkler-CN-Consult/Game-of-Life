<?php

namespace Rules;

use GOL\Boards\Board;
use GOL\Rules\CopyRule;
use PHPUnit\Framework\TestCase;

class CopyRuleTest extends TestCase
{

    /**
     * @test
     */
    public function surviveOn1Neighbour()
    {
        $board = new Board(4, 4);
        $rule = new CopyRule();

        $board->setFieldValue(1, 1, true);

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
        $rule = new CopyRule();

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
    public function surviveOn5Neighbours()
    {
        $board = new Board(4, 4);
        $rule = new CopyRule();

        $board->setFieldValue(1, 1, true);

        $board->setFieldValue(0, 0, true);
        $board->setFieldValue(0, 1, true);
        $board->setFieldValue(1, 0, true);
        $board->setFieldValue(1, 2, true);
        $board->setFieldValue(2, 0, true);

        $newValue = $rule->apply($board->field(1, 1));
        $this->assertTrue($newValue);
    }

    /**
     * @test
     */
    public function surviveOn7Neighbours()
    {
        $board = new Board(4, 4);
        $rule = new CopyRule();

        $board->setFieldValue(1, 1, true);

        $board->setFieldValue(0, 0, true);
        $board->setFieldValue(0, 1, true);
        $board->setFieldValue(1, 0, true);
        $board->setFieldValue(1, 2, true);
        $board->setFieldValue(2, 0, true);
        $board->setFieldValue(2, 1, true);
        $board->setFieldValue(0, 2, true);

        $newValue = $rule->apply($board->field(1, 1));
        $this->assertTrue($newValue);
    }

    /**
     * @test
     */
    public function birthOn1Neighbour()
    {
        $board = new Board(4, 4);
        $rule = new CopyRule();

        $board->setFieldValue(0, 1, true);

        $newValue = $rule->apply($board->field(1, 1));
        $this->assertTrue($newValue);
    }

    /**
     * @test
     */
    public function birthOn3Neighboura()
    {
        $board = new Board(4, 4);
        $rule = new CopyRule();

        $board->setFieldValue(0, 0, true);
        $board->setFieldValue(0, 1, true);
        $board->setFieldValue(1, 0, true);

        $newValue = $rule->apply($board->field(1, 1));
        $this->assertTrue($newValue);
    }

    /**
     * @test
     */
    public function birthOn5Neighbours()
    {
        $board = new Board(4, 4);
        $rule = new CopyRule();

        $board->setFieldValue(0, 0, true);
        $board->setFieldValue(0, 1, true);
        $board->setFieldValue(1, 0, true);
        $board->setFieldValue(1, 2, true);
        $board->setFieldValue(2, 0, true);

        $newValue = $rule->apply($board->field(1, 1));
        $this->assertTrue($newValue);
    }

    /**
     * @test
     */
    public function birthOn7Neighbours()
    {
        $board = new Board(4, 4);
        $rule = new CopyRule();

        $board->setFieldValue(0, 0, true);
        $board->setFieldValue(0, 1, true);
        $board->setFieldValue(1, 0, true);
        $board->setFieldValue(1, 2, true);
        $board->setFieldValue(2, 0, true);
        $board->setFieldValue(2, 1, true);
        $board->setFieldValue(0, 2, true);

        $newValue = $rule->apply($board->field(1, 1));
        $this->assertTrue($newValue);
    }
}
