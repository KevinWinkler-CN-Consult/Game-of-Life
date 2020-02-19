<?php

namespace Boards;

use GOL\Boards\Board;
use GOL\Boards\Field;
use PHPUnit\Framework\TestCase;

class FieldTest extends TestCase
{
    /**
     * @test
     */
    public function constructedValuesAreReturned()
    {
        $board = new Board(4, 4);
        $cell = new Field($board, 1, 2);
        $this->assertEquals(1, $cell->x());
        $this->assertEquals(2, $cell->y());
    }

    /**
     * @test
     */
    public function setValueEqualsGetValue()
    {
        $board = new Board(4, 4);
        $cell = new Field($board, 0, 0);

        $cell->setValue(69);
        $this->assertEquals(69, $cell->value());
    }

    /**
     * @test
     */
    public function isAlive()
    {
        $board = new Board(4, 4);
        $cell = new Field($board, 0, 0);
        $cell->setValue(1);
        $this->assertTrue($cell->isAlive());
    }

    /**
     * @test
     */
    public function isDead()
    {
        $board = new Board(4, 4);
        $cell = new Field($board, 0, 0);

        $this->assertTrue($cell->isDead());
    }

    /**
     * @test
     */
    public function numberLivingNeighbours()
    {
        $board = new Board(4, 4);
        $cell = new Field($board, 0, 0);

        $cell->numberOfLivingNeighbors();

        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function numberLivingNeighbours2()
    {
        $board = new Board(4, 4);
        $board->setFieldValue(0, 0, true);
        $board->setFieldValue(2, 2, true);

        $num = $board->field(1, 1)->numberOfLivingNeighbors();

        $this->assertEquals(2, $num);
    }

    /**
     * @test
     */
    public function numberDeadNeighbours()
    {
        $board = new Board(4, 4);
        $cell = new Field($board, 0, 0);

        $cell->numberOfDeadNeighbors();

        $this->assertTrue(true);
    }


    /**
     * @test
     */
    public function numberDeadNeighbours2()
    {
        $board = new Board(4, 4);
        $board->setFieldValue(0, 0, true);
        $board->setFieldValue(2, 2, true);

        $num = $board->field(1, 1)->numberOfDeadNeighbors();

        $this->assertEquals(6, $num);
    }
}
